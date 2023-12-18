<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use App\Notifications\SubscriptionRenewalNotification;
use App\Notifications\SubscriptionCancelNotification;
use App\Notifications\SubscriptionReminderNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SubscriptionService
{
    public static function activateUserSubscription(int $userId, int $subscriptionId, string $paymentMethodId, string $paymentMethod): bool
    {
        $subscription = Subscription::with('courses')->find($subscriptionId);
        $user = User::find($userId);

        if ($subscription === null || $user === null)
            return false;

        $user->subscription_id = $subscription->id;
        $user->payment_method_id = $paymentMethodId;
        $user->payment_method = $paymentMethod;
        $user->calls += $subscription->calls;

        $user->save();

        User::whereId($user->id)->update(['subscription_end_date' =>
            DB::raw('DATE_ADD(NOW(), INTERVAL ' . $subscription->period_in_months . ' MONTH)')]);

        if ($user->moodle_id == null)
        {
            $moodleId = MoodleService::createNewUser($user);

            if ($moodleId !== false)
                $user->fill(['moodle_id' => $moodleId])->save();
        }

        MoodleService::enrolUserInCourses($user->moodle_id, $subscription->courses->toArray());

        Notification::send([$user], new SubscriptionRenewalNotification(true));

        return true;
    }

    public static function deactivateUserSubscription(int $userId): bool
    {
        $user = User::find($userId);

        if ($user === null)
            return false;

        $user->subscription_id = null;
        $user->payment_method_id = null;
        $user->payment_method = '';
        $user->subscription_end_date = null;

        $user->save();

        MoodleService::unenrollUserFromAllCourses($user->moodle_id);
        Notification::send([$user], new SubscriptionRenewalNotification(false));

        return true;
    }

    public static function updateUsersSubscriptions(YooKassaService $service): void
    {
        $users = User::with('subscription')
            ->whereDate('subscription_end_date', date('Y-m-d'))
            ->get();

        foreach ($users as $user)
        {
            if ($user->payment_method_id === null)
            {
                $user->subscription_id = null;
                $user->subscription_end_date = null;
                $user->save();

                MoodleService::unenrollUserFromAllCourses($user->moodle_id);
                Notification::send([$user], new SubscriptionCancelNotification());
            } else
                try
                {
                    $service->createAutoPayment($user->subscription_id, $user->id, $user->payment_method_id);
                } catch (\Exception $e)
                {
                    $user->subscription_id = null;
                    $user->subscription_end_date = null;
                    $user->save();

                    Notification::send([$user], new SubscriptionRenewalNotification(false));
                }
        }
    }

    public static function checkUsersSubscriptions(): void
    {
        $users = User::whereRaw('DATEDIFF(subscription_end_date, now()) = ?', [2])->get();
        Notification::send($users, new SubscriptionReminderNotification());
    }

    public static function addCallsToUser(int $userId, int $calls): bool
    {
        $user = User::find($userId);

        if ($user === null)
            return false;

        $user->calls += $calls;

        $user->save();

        return true;
    }
}
