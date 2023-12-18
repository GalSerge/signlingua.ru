<?php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Http\Response;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use YooKassa\Client;
use App\Models\Payment;

use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Notification\NotificationEventType;

//use YooKassa\Model\NotificationFactory;
use YooKassa\Model\CurrencyCode;

class YooKassaService
{
    private function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );

        return $client;
    }

    public function getPaymentLink(Payment $payment, bool $savePaymentMethod = false): string
    {
        $client = $this->getClient();

        $response = $client->createPayment(
            [
                'amount' => [
                    'value' => $payment->amount,
                    'currency' => CurrencyCode::RUB,
                ],
                'capture' => true,
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => route('payments.index')
                ],
                'save_payment_method' => $savePaymentMethod,
                'description' => $payment->description,
                'metadata' => [
                    'payment_id' => $payment->id,
                    'user_id' => $payment->user_id
                ],
            ],
            uniqid('', true)
        );

        $payment->payment_id = $response->getId();
        $payment->save();

        return $response->getConfirmation()->getConfirmationUrl();
    }

    public function checkLastPayment(int $userId): void
    {
        $payments = Payment::where('user_id', $userId)
            ->where('status', PaymentStatusEnum::WAITING)
            ->orWhere('status', PaymentStatusEnum::PENDING)
            ->get();

        if ($payments->count() == 0)
            return;

        $client = $this->getClient();

        foreach ($payments as $payment)
        {
            try
            {
                $paymentResponse = $client->getPaymentInfo($payment->payment_id);
            } catch (YooKassa\Common\Exceptions\NotFoundException $e)
            {
                $payment->forceDelete();
            }

            if (isset($paymentResponse->status) && $paymentResponse->status === 'succeeded' && (bool)$paymentResponse->paid === true)
                $this->manageSuccessfulPayment($paymentResponse);
            elseif (isset($paymentResponse->status) && $paymentResponse->status === 'canceled')
                $this->manageCanceledPayment($paymentResponse);
        }
    }

    public function updatePaymentStatus(int $paymentId, string $paymentStatus): bool
    {
        $payment = Payment::findOrFail($paymentId);

        $payment->status = $paymentStatus;
        $payment->save();

        return true;
    }

    public function createAutoPayment(int $subscriptionId, int $userId, string $paymentMethodId): void
    {
        $client = $this->getClient();

        $subscription = Subscription::findOrFail($subscriptionId);

        $payment = Payment::create(
            [
                'amount' => $subscription->amount,
                'description' => 'Продление подписки: ' . $subscription->name,
                'subscription_id' => $subscription->id,
                'user_id' => $userId,
                'type' => PaymentTypeEnum::RENEWAL,
                'status' => PaymentStatusEnum::WAITING
            ]);

        $response = $client->createPayment(
            [
                'amount' => [
                    'value' => $payment->amount,
                    'currency' => CurrencyCode::RUB,
                ],
                'capture' => true,
                'payment_method_id' => $paymentMethodId,
                'description' => $payment->description,
                'metadata' => [
                    'payment_id' => $payment->id,
                    'user_id' => $payment->user_id
                ],
            ],
            uniqid('', true)
        );

        $payment->payment_id = $response->getId();
        $payment->save();
    }

    public function refundPayment(Payment $payment): bool
    {
        $status = false;
        $client = $this->getClient();

        $response = $client->createRefund(
            [
                'payment_id' => $payment->payment_id,
                'amount' => [
                    'value' => $payment->amount,
                    'currency' => CurrencyCode::RUB,
                ],
            ],
            uniqid('', true)
        );

        if ($response->getStatus() == 'succeeded')
        {
            $payment->status = PaymentStatusEnum::REFUNDED;
            $status = true;
        } else
            $payment->status = PaymentStatusEnum::CANCELED_REFUND;

        $payment->save();

        return $status;
    }

    public function manageSuccessfulPayment(object $paymentResponse): bool
    {
        $metadata = $paymentResponse->metadata;

        if (isset($metadata->payment_id))
        {
            $payment = Payment::with('user')->findOrFail($metadata->payment_id);
            $payment->status = PaymentStatusEnum::SUCCEEDED;
            $payment->save();

            if ($payment->type == PaymentTypeEnum::TRIAL)
            {
                $payment->user->payment_method_id = $paymentResponse->payment_method->id;
                $payment->user->payment_method = $paymentResponse->payment_method->title;
                $payment->user->save();

                $this->refundPayment($payment);
            }
            elseif ($payment->type == PaymentTypeEnum::BUYSUB || $payment->type == PaymentTypeEnum::RENEWAL)
                SubscriptionService::activateUserSubscription(
                    (int)$metadata->user_id,
                    (int)$payment->subscription_id,
                    $paymentResponse->payment_method->id,
                    $paymentResponse->payment_method->title
                );
            else
                SubscriptionService::addCallsToUser((int)$metadata->user_id, (int)$payment->calls);

            return true;
        }

        return false;
    }

    public function manageCanceledPayment(object $paymentResponse): bool
    {
        $metadata = $paymentResponse->metadata;

        if (isset($metadata->payment_id))
        {
            $payment = Payment::with('user')->findOrFail($metadata->payment_id);
            $payment->status = PaymentStatusEnum::CANCELED;
            $payment->save();

            if ($payment->type == PaymentTypeEnum::TRIAL)
            {
                $payment->user->payment_method_id = null;
                $payment->user->payment_method = '';
                $payment->user->save();
            } elseif ($payment->type == PaymentTypeEnum::RENEWAL)
                SubscriptionService::deactivateUserSubscription((int)$metadata->user_id);

            return true;
        }

        return false;
    }

    public function processNotification(object $dataNotification): Response
    {
        $status = false;
        $payment = $dataNotification->object;

        if ($dataNotification->event === NotificationEventType::PAYMENT_SUCCEEDED)
        {
            if (isset($payment->status) && $payment->status === 'succeeded' && (bool)$payment->paid === true)
            {
                $status = $this->manageSuccessfulPayment($payment);
            }
        } elseif ($dataNotification->event === NotificationEventType::PAYMENT_CANCELED)
        {
            if (isset($payment->status) && $payment->status === 'canceled')
            {
                $status = $this->manageCanceledPayment($payment);
            }
        }

        if ($status)
            return response('Ok', 200);
        else
            return response('Something went wrong', 500);

    }
}
