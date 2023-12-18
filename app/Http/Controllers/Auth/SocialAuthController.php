<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\OAuth2\User as SocialitePUser;
use Laravel\Socialite\Two\User as SocialiteUser;
use \Intervention\Image\Facades\Image;
use App\Models\Role;
use App\Models\User;

use App\Services\MoodleService;

class SocialAuthController extends Controller
{
    public function callback(string $provider): RedirectResponse
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e)
        {
            return redirect()->route('login');
        }

        switch ($provider)
        {
            case 'yandex':
                $userInfo = $this->getUserInfoFromYandex($socialUser);
                $userInfo['auth_provider'] = $provider;
                break;
            case 'vkontakte':
                $userInfo = $this->getUserInfoFromVkontakte($socialUser);
                $userInfo['auth_provider'] = $provider;
                break;
            case 'google':
                $userInfo = $this->getUserInfoFromGoogle($socialUser);
                $userInfo['auth_provider'] = $provider;
                break;
            default:
                return redirect()->route('login');
        }

        $userInfo['email'] = Str::lower($userInfo['email']);

        $user = User::where('email', $userInfo['email'])->first();

        if (!$user)
        {
            $userInfo['img'] = $this->saveImg($userInfo['img']);

            $role = Role::where('tag', 'user')->first();
            $user = $role->users()->create($userInfo);

            $moodleId = MoodleService::createNewUser($user);

            if ($moodleId != false)
            {
                $user->fill(['moodle_id' => $moodleId])->save();
                MoodleService::enrolUserInBetaCourses($moodleId);
            }

            event(new Registered($user));
        }

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }


    private function getUserInfoFromVkontakte(SocialitePUser $user): array
    {
        return [];
    }

    private function getUserInfoFromYandex(SocialitePUser $user): array
    {
        return [
            'name' => $user->user['first_name'],
            'surname' => $user->user['last_name'],
            'email' => $user->email,
            'img' => $user->avatar,
            'password' => Hash::make(Str::password(15)),
            'email_verified_at' => date('Y-m-d H:i:s')
        ];
    }

    private function getUserInfoFromGoogle(SocialiteUser $user): array
    {
        return [
            'name' => $user->user['given_name'],
            'surname' => $user->user['family_name'],
            'email' => $user->email,
            'img' => $user->avatar,
            'password' => Hash::make(Str::password(15)),
            'email_verified_at' => date('Y-m-d H:i:s')
        ];
    }

    private function saveImg(string $avatar): string
    {
        $img = uniqid() . '.jpg';

        Image::make($avatar)
            ->resize(100, null,
                function ($constraint) {
                    $constraint->aspectRatio();
                })
            ->encode('jpg')
            ->save(public_path('storage/images/users/' . $img));

        return $img;
    }
}

/*
 https://yandex.ru/dev/id/doc/ru/user-information
https://socialiteproviders.com/VKontakte/#register-an-application
https://console.cloud.google.com/apis/credentials/oauthclient/746705923029-b9861emu62fq3a920lbh294vtlqa68b5.apps.googleusercontent.com?hl=ru&project=sign-speaks

 */
