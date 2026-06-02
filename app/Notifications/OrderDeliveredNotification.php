<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];
        if (\App\Models\Setting::get('sms_enabled', false, 'notifications')) {
            $channels[] = \App\Notifications\Channels\SmsChannel::class;
        }
        if (\App\Models\Setting::get('whatsapp_enabled', false, 'notifications')) {
            $channels[] = \App\Notifications\Channels\WhatsAppChannel::class;
        }
        return $channels;
    }

    public function toSms(object $notifiable): string
    {
        return 'Order ' . $this->order->order_number . ' delivered! Warranty starts today. Rate it: '
            . route('account.orders.show', $this->order);
    }

    public function toWhatsApp(object $notifiable): string
    {
        return $this->toSms($notifiable);
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order delivered – ' . $this->order->order_number)
            ->greeting('Hi ' . $this->order->billing_name . ',')
            ->line('Your order **' . $this->order->order_number . '** has been delivered. We hope everything looks great!')
            ->line('Your warranty starts today. Save the invoice for future reference.')
            ->action('Rate your purchase', route('account.orders.show', $this->order))
            ->line('Have feedback? Reply to this email — we read every message.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'message' => 'Order ' . $this->order->order_number . ' delivered.',
        ];
    }
}
