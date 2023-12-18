<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $subscription = $request->user()->subscription;

        if ($subscription !== null)
            $subscription = $subscription->toArray();

        return view('profile.pages.subscription',
            [
                'subscription' => $subscription,
                'date_end' => date('d.m.Y', strtotime($request->user()->subscription_end_date))
            ]);
    }

    public function cancel(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->payment_method_id = null;
        $user->payment_method = '';
        $user->save();

        return redirect()->back()->with('status', 'Автопродление подписки отменено. Приобретенные опции доступны до конца предоставленного периода.');
    }
}
