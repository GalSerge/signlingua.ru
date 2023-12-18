<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Constant;
use App\Services\YooKassaService;
use App\Enums\PaymentTypeEnum;
use App\Enums\PaymentStatusEnum;

use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request, YooKassaService $service): View
    {
        $service->checkLastPayment($request->user()->id);

        return view('profile.pages.payments',
            ['payments' => Payment::where('user_id', $request->user()->id)
                ->orderBy('updated_at', 'desc')
                ->get()
                ->toArray()
            ]);
    }

    private function makePayment(Payment $payment, bool $savePaymentMethod): RedirectResponse
    {
        $kassaService = new YooKassaService();

        try
        {
            $link = $kassaService->getPaymentLink($payment, $savePaymentMethod);
        } catch (\Exception $e)
        {
            return back()->with('error', 'Что-то пошло не так...');
        }

        if (filter_var($link, FILTER_VALIDATE_URL))
            return redirect()->away($link);
        else
            return redirect()->back()->with('error', 'Что-то пошло не так...');
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $validatedData = $request->validate(['sub_id' => ['required', 'integer']]);

        $subscription = Subscription::findOrFail($validatedData['sub_id']);

        $payment = Payment::create(
            [
                'amount' => $subscription->amount,
                'description' => 'Оформление подписки: ' . $subscription->name,
                'subscription_id' => $subscription->id,
                'user_id' => $request->user()->id,
                'type' => PaymentTypeEnum::BUYSUB
            ]);

        return $this->makePayment($payment, true);
    }

    public function buyCalls(Request $request): RedirectResponse
    {
        $validatedData = $request->validate(['calls' => ['required', 'integer', 'max:5', 'min:1']]);
        $calls = $validatedData['calls'];

        $constants = Constant::find(1);

        $payment = Payment::create(
            [
                'amount' => $constants->call_amount * $calls,
                'calls' => $calls,
                'description' => 'Покупка звонков',
                'user_id' => $request->user()->id,
                'type' => PaymentTypeEnum::BUYCALL
            ]
        );

        return $this->makePayment($payment, false);
    }

    public function trial(Request $request)
    {
        $constants = Constant::find(1);

        $payment = Payment::create(
            [
                'amount' => $constants->trial_amount,
                'description' => 'Пробный платеж',
                'user_id' => $request->user()->id,
                'type' => PaymentTypeEnum::TRIAL
            ]
        );

        return $this->makePayment($payment, true);
    }

    public function callback(YooKassaService $kassaService): Response
    {
        $data = json_decode(file_get_contents('php://input'));

        try
        {
            $response = $kassaService->processNotification($data);
        } catch (\Exception $e)
        {
            $response = response('Something went wrong', 400);
        }

        return $response;
    }

    public function waitPayment(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = PaymentStatusEnum::WAITING;
        $payment->save();

        return redirect()->route('payments.index');
    }
}
