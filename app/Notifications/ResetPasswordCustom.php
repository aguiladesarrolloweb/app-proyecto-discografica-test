<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordCustom  extends ResetPasswordNotification
{

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
        ->subject(__('notifications.password_reset.subject'))
        ->greeting(__('notifications.password_reset.greeting'))
        ->line(__('notifications.password_reset.intro'))
        ->action(__('notifications.password_reset.action'), $url)
        ->line(__('notifications.password_reset.outro'))
        ->salutation(env("APP_NAME"))
        ->line(__('notifications.password_reset.salutation'));
    }
}
