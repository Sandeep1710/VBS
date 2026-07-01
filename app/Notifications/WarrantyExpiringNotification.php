<?php

namespace App\Notifications;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WarrantyExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly OrderItem $item,
        public readonly int $daysLeft,
    ) {
    }

    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];
        if (\App\Models\Setting::get('sms_enabled', false, 'notifications')) {
            $channels[] = \App\Notifications\Channels\SmsChannel::class;
        }
        return $channels;
    }

    public function toSms(object $notifiable): string
    {
        return "Your {$this->item->product_name} warranty expires in {$this->daysLeft} days. Visit "
            . url('/account/orders') . " for details.";
    }

    public function toMail(object $notifiable): MailMessage
    {
        $endsAt = $this->item->warranty_ends_at?->format('d M Y');

        return (new MailMessage)
            ->subject("Warranty expiring soon — {$this->daysLeft} days left")
            ->greeting('Hi ' . ($notifiable->name ?? 'there') . ',')
            ->line("Your battery **{$this->item->product_name}** has only {$this->daysLeft} days of manufacturer warranty left.")
            ->line($endsAt ? "Warranty ends on **{$endsAt}**." : '')
            ->line('If you noticed any issues, raise a warranty claim before the period ends.')
            ->action('View order', route('account.orders.show', $this->item->order))
            ->line('Thank you for shopping with Trikuti Battery.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_item_id' => $this->item->id,
            'product_name' => $this->item->product_name,
            'days_left' => $this->daysLeft,
            'message' => "Warranty for {$this->item->product_name} expires in {$this->daysLeft} days.",
        ];
    }
}
