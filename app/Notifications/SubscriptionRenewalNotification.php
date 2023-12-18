<?php

namespace App\Notifications;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionRenewalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private bool $success)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($this->success)
            $subject = 'Активация подписки';
        else
            $subject = 'Отмена подписки';

        return (new MailMessage)
            ->subject(config('app.name') . ' | ' . $subject)
            ->view('emails.sub-renewal', [
                'subscription' => $notifiable->subscription,
                'user' => $notifiable,
                'success' => $this->success,
                'title' => $subject
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'msg' => ($this->success ? 'Подписка активирована.' : 'Не удалось активировать подписку.')
        ];
    }
}
