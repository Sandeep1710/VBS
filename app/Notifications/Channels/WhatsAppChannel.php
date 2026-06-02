<?php

namespace App\Notifications\Channels;

use App\Contracts\Notifications\WhatsAppGatewayContract;
use App\Models\Setting;
use Illuminate\Notifications\Notification;

class WhatsAppChannel
{
    public function __construct(private readonly WhatsAppGatewayContract $gateway)
    {
    }

    public function send(object $notifiable, Notification $notification): ?array
    {
        if (! Setting::get('whatsapp_enabled', false, 'notifications')) {
            return null;
        }

        if (! method_exists($notification, 'toWhatsApp')) {
            return null;
        }

        $phone = $notifiable->routeNotificationFor('whatsapp', $notification)
            ?? ($notifiable->phone ?? null);

        if (! $phone) {
            return null;
        }

        $message = $notification->toWhatsApp($notifiable);

        return $this->gateway->send($phone, $message);
    }
}
