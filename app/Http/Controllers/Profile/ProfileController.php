<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use \Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.pages.personal', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'img' => ['nullable', 'file', 'mimes:jpg,bmp,png'],
            'name' => ['string', 'max:255'],
            'surname' => ['string', 'max:255'],
        ]);

        if (isset($validatedData['img']))
        {
            if ($request->user()->img == '')
                $nameImg = uniqid() . '.jpg';
            else
                $nameImg = $request->user()->img;

            $this->saveImg($validatedData['img'], $nameImg);

            $validatedData['img'] = $nameImg;
        }

        $request->user()->fill($validatedData);

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function readNotifications(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    private function saveImg(string $avatar, string $name): void
    {
        Image::make($avatar)
            ->resize(100, null,
                function ($constraint) {
                    $constraint->aspectRatio();
                })
            ->encode('jpg')
            ->save(public_path('storage/images/users/' . $name));
    }
}
