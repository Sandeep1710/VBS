<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderDeliveredNotification;
use App\Notifications\OrderDispatchedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RuntimeException;

class OrderStatusService
{
    public const ADMIN_TRANSITIONS = [
        Order::STATUS_PENDING => [Order::STATUS_CONFIRMED, Order::STATUS_CANCELLED],
        Order::STATUS_CONFIRMED => [Order::STATUS_DISPATCHED, Order::STATUS_CANCELLED],
        Order::STATUS_DISPATCHED => [Order::STATUS_DELIVERED, Order::STATUS_CANCELLED],
        Order::STATUS_DELIVERED => [Order::STATUS_COMPLETED],
        Order::STATUS_COMPLETED => [],
        Order::STATUS_CANCELLED => [],
    ];

    public function nextOptions(Order $order): array
    {
        return self::ADMIN_TRANSITIONS[$order->status] ?? [];
    }

    public function changeStatus(Order $order, string $newStatus, ?User $actor = null, ?string $comment = null): Order
    {
        $allowed = $this->nextOptions($order);
        if (! in_array($newStatus, $allowed, true)) {
            throw new RuntimeException("Cannot move order from {$order->status} to {$newStatus}.");
        }

        return DB::transaction(function () use ($order, $newStatus, $actor, $comment) {
            $previous = $order->status;
            $now = now();

            $updates = ['status' => $newStatus];

            switch ($newStatus) {
                case Order::STATUS_CONFIRMED:
                    $updates['confirmed_at'] = $now;
                    break;
                case Order::STATUS_DISPATCHED:
                    $updates['dispatched_at'] = $now;
                    break;
                case Order::STATUS_DELIVERED:
                    $updates['delivered_at'] = $now;
                    if ($order->payment_method === 'cod') {
                        $updates['payment_status'] = Order::PAY_PAID;
                    }
                    break;
                case Order::STATUS_COMPLETED:
                    $updates['completed_at'] = $now;
                    break;
                case Order::STATUS_CANCELLED:
                    $updates['cancelled_at'] = $now;
                    $updates['cancellation_reason'] = $comment ?: 'Cancelled by admin.';
                    $this->restoreStock($order);
                    break;
            }

            $order->forceFill($updates)->save();

            OrderStatusLog::create([
                'order_id' => $order->id,
                'from_status' => $previous,
                'to_status' => $newStatus,
                'comment' => $comment,
                'changed_by' => $actor?->id,
                'source' => $actor ? 'admin' : 'system',
            ]);

            $this->dispatchNotifications($order, $newStatus);

            return $order->fresh();
        });
    }

    public function markPaymentReceived(Order $order, ?User $actor = null): Order
    {
        if ($order->payment_status === Order::PAY_PAID) {
            return $order;
        }

        $order->forceFill(['payment_status' => Order::PAY_PAID])->save();

        OrderStatusLog::create([
            'order_id' => $order->id,
            'from_status' => $order->status,
            'to_status' => $order->status,
            'comment' => 'Payment marked received.',
            'changed_by' => $actor?->id,
            'source' => 'admin',
        ]);

        if ($payment = $order->payments()->latest()->first()) {
            $payment->forceFill([
                'status' => 'success',
                'paid_at' => now(),
            ])->save();
        }

        return $order->fresh();
    }

    private function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_id) {
                Product::where('id', $item->product_id)
                    ->update(['stock_quantity' => DB::raw('stock_quantity + ' . (int) $item->quantity)]);
            }
        }
    }

    private function dispatchNotifications(Order $order, string $newStatus): void
    {
        if (! $order->user) {
            return;
        }

        $notification = match ($newStatus) {
            Order::STATUS_DISPATCHED => new OrderDispatchedNotification($order),
            Order::STATUS_DELIVERED => new OrderDeliveredNotification($order),
            default => null,
        };

        if ($notification) {
            Notification::send($order->user, $notification);
        }
    }
}
