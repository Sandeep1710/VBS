<?php

namespace App\Console\Commands;

use App\Models\OrderItem;
use App\Notifications\WarrantyExpiringNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendWarrantyReminders extends Command
{
    protected $signature = 'vbs:send-warranty-reminders {--days=30 : Days before warranty ends to send the reminder}';

    protected $description = 'Send warranty-expiring reminder emails to customers.';

    public function handle(): int
    {
        $daysBefore = (int) $this->option('days');
        $target = now()->addDays($daysBefore)->startOfDay();
        $end = now()->addDays($daysBefore)->endOfDay();

        $items = OrderItem::query()
            ->whereNotNull('warranty_ends_at')
            ->whereBetween('warranty_ends_at', [$target, $end])
            ->with('order.user')
            ->get();

        $sent = 0;
        foreach ($items as $item) {
            $user = $item->order?->user;
            if (! $user || ! $user->email) {
                continue;
            }
            // Idempotency — skip if we already notified this user about this item
            $alreadyNotified = $user->notifications()
                ->where('type', WarrantyExpiringNotification::class)
                ->where('data->order_item_id', $item->id)
                ->exists();
            if ($alreadyNotified) {
                continue;
            }

            Notification::send($user, new WarrantyExpiringNotification($item, $daysBefore));
            $sent++;
        }

        $this->info("Sent {$sent} warranty reminder(s) for items expiring in {$daysBefore} days.");
        return self::SUCCESS;
    }
}
