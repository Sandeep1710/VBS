<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpCodeNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $code,
        public readonly string $purpose,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $purposeLabel = match ($this->purpose) {
            'login' => 'sign in',
            'register' => 'create your account',
            'password_reset' => 'reset your password',
            'phone_verify' => 'verify your phone',
            'email_verify' => 'verify your email',
            default => 'continue',
        };

        return (new MailMessage)
            ->subject('Your verification code')
            ->greeting('Hi there,')
            ->line("Use this code to {$purposeLabel}:")
            ->line('**' . $this->code . '**')
            ->line('This code will expire in 10 minutes. Do not share it with anyone.')
            ->salutation('— Vehicle Battery Store');
    }
}
