<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Constant;
use App\Mail\FeedbackMail;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View
    {
        return view('pages.feedback');
    }

    public function send(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'msg' => ['required'],
            'img' => ['nullable', 'image']
        ]);

        $constants = Constant::find(1);

        if ($request->user())
        {
            $validatedData['name'] = $request->user()->name . ' ' . $request->user()->surname;
            $validatedData['email'] = $request->user()->email;
        }

        try {
            Mail::to($constants->feedback_email)->send(new FeedbackMail(...$validatedData));
        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'При отправке сообщения произошла ошибка. Повторите попытку позже.');
        }

        return redirect()->back()->with('status', 'Сообщение успешно отправлено.');
    }
}
