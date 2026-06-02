<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
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
        return 'Order ' . $this->order->order_number . ' placed. Total ₹'
            . number_format((float) $this->order->total, 0)
            . '. Track at ' . route('account.orders.show', $this->order);
    }

    public function toWhatsApp(object $notifiable): string
    {
        return $this->toSms($notifiable);
    }

    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing('items');
        $itemsCount = $order->items->sum('quantity');

        $message = (new MailMessage)
            ->subject('Order confirmation – ' . $order->order_number)
            ->greeting('Hi ' . $order->billing_name . ',')
            ->line('Thanks for your order! We have received it and will start processing it shortly.')
            ->line('**Order:** ' . $order->order_number)
            ->line('**Items:** ' . $itemsCount . ' battery item(s)')
            ->line('**Total:** ₹' . number_format((float) $order->total, 2))
            ->line('**Payment method:** ' . strtoupper($order->payment_method))
            ->action('View order', route('account.orders.show', $order))
            ->line('We will notify you when your order is dispatched.');

        if ($order->exchange_pickup_required) {
            $message->line('Please keep your old battery ready for exchange pickup.');
        }

        return $message->salutation('— Vehicle Battery Store');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total,
            'message' => 'Order ' . $this->order->order_number . ' placed successfully.',
        ];
    }
}
