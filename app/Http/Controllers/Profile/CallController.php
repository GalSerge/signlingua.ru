<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Call;
use App\Models\Constant;
use App\Enums\CallStatusEnum;

class CallController extends Controller
{
    public function index(Request $request): View
    {
        $constants = Constant::find(1);

        return view('profile.pages.calls',
            [
                'available' => $request->user()->calls,
                'committed' => Call::where('user_id', $request->user()->id)
                    ->where('status', CallStatusEnum::SATISFIED)
                    ->count(),
                'calls' => Call::with('tutor')->where('user_id', $request->user()->id)
                    ->orderBy('updated_at', 'desc')
                    ->get()
                    ->toArray(),
                'amount_one_call' => $constants['call_amount']
            ]);
    }

    private function existRequestedCall(int $userId): bool
    {
        $call = Call::where('user_id', $userId)
            ->where('status', CallStatusEnum::REQUESTED)
            ->first();

        return (bool)$call;
    }

    public function requestCall(Request $request): RedirectResponse
    {
        if ($request->user()->calls <= 0)
            return redirect()->back()->with('error', 'У вас нет доступных звонков.');

        if ($this->existRequestedCall($request->user()->id))
            return redirect()->back()->with('error', 'У вас уже есть запрошенный звонок.');

        try
        {
            $validatedData = $request->validate(['msg' => 'required']);
        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Введите сообщение.');
        }

        Call::create(
            [
                'user_id' => $request->user()->id,
                'msg' => $validatedData['msg'],
            ]
        );

        $request->user()->calls -= 1;
        $request->user()->save();

        return redirect()->back()->with('status', 'Новый звонок запрошен.');
    }
}

