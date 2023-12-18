<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->view('emails.verify-email',
                    [
                        'url' => $url, 'title' => 'Подтверждение email'
                    ])
                ->subject(config('app.name') . ' | Подтверждение email');
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new MailMessage)
                ->view('emails.reset',
                    [
                        'url' => route('password.reset', $token) . '?email=' . $notifiable->email,
                        'title' => 'Восстановление пароля'
                    ])
                ->subject(config('app.name') . ' | Восстановление пароля');
        });
    }
}
