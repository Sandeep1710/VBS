<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDispatchedNotification extends Notification implements ShouldQueue
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
        return 'Your order ' . $this->order->order_number . ' is on the way. Track: '
            . route('account.orders.show', $this->order);
    }

    public function toWhatsApp(object $notifiable): string
    {
        return $this->toSms($notifiable);
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your order is on the way – ' . $this->order->order_number)
            ->greeting('Hi ' . $this->order->billing_name . ',')
            ->line('Good news — your order **' . $this->order->order_number . '** has been dispatched.')
            ->line('We\'ll let you know once it\'s delivered. Please keep your old battery ready if you opted for exchange.')
            ->action('Track order', route('account.orders.show', $this->order))
            ->line('Thanks for shopping with Trikuti Battery.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'message' => 'Order ' . $this->order->order_number . ' dispatched.',
        ];
    }
}
