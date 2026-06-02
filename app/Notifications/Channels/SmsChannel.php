<?php

namespace App\Notifications\Channels;

use App\Contracts\Notifications\SmsGatewayContract;
use App\Models\Setting;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function __construct(private readonly SmsGatewayContract $gateway)
    {
    }

    public function send(object $notifiable, Notification $notification): ?array
    {
        if (! Setting::get('sms_enabled', false, 'notifications')) {
            return null;
        }

        if (! method_exists($notification, 'toSms')) {
            return null;
        }

        $phone = $notifiable->routeNotificationFor('sms', $notification)
            ?? ($notifiable->phone ?? null);

        if (! $phone) {
            return null;
        }

        $message = $notification->toSms($notifiable);

        return $this->gateway->send($phone, $message);
    }
}
