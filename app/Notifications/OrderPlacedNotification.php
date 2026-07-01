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
        $supportPhone = \App\Models\Setting::get('support_phone', '+91 9920971479');

        $message = (new MailMessage)
            ->subject('Order received – ' . $order->order_number)
            ->greeting('Hi ' . $order->billing_name . ',')
            ->line('Thanks for choosing us! We have received your order and our team will call you within **4 working hours** at ' . $order->billing_phone . ' to confirm the battery model and schedule delivery.')
            ->line('**Order:** ' . $order->order_number)
            ->line('**Items:** ' . $itemsCount . ' battery item(s)')
            ->line('**Estimated total:** ₹' . number_format((float) $order->total, 2))
            ->line('**Payment:** Cash on Delivery')
            ->action('View order', route('account.orders.show', $order))
            ->line('Need to reach us first? Call or WhatsApp **' . $supportPhone . '** — Mon to Sat, 9 AM to 8 PM.');

        if ($order->exchange_pickup_required) {
            $message->line('Please keep your old battery ready for exchange pickup.');
        }

        return $message->salutation('— Trikuti Battery');
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
