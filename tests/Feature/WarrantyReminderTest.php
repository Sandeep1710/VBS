<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\WarrantyExpiringNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class WarrantyReminderTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder($user): Order
    {
        return Order::create([
            'order_number' => 'VBS' . str_pad((string) random_int(1, 99999), 8, '0', STR_PAD_LEFT),
            'user_id' => $user->id,
            'subtotal' => 5000, 'total' => 5000,
            'billing_name' => 'T', 'billing_phone' => '1', 'billing_line1' => 'X',
            'billing_city' => 'X', 'billing_state' => 'X', 'billing_pincode' => '111111',
            'shipping_name' => 'T', 'shipping_phone' => '1', 'shipping_line1' => 'X',
            'shipping_city' => 'X', 'shipping_state' => 'X', 'shipping_pincode' => '111111',
            'payment_method' => 'cod',
            'status' => Order::STATUS_DELIVERED,
        ]);
    }

    public function test_command_sends_to_items_expiring_in_window(): void
    {
        Notification::fake();
        $user = $this->makeCustomer();
        $order = $this->makeOrder($user);

        // One item expiring exactly in 30 days (target window)
        OrderItem::create([
            'order_id' => $order->id,
            'product_name' => 'Hit Battery',
            'product_sku' => 'HIT',
            'quantity' => 1,
            'price' => 5000,
            'subtotal' => 5000, 'total' => 5000,
            'warranty_months' => 24,
            'warranty_starts_at' => now()->subDays(700),
            'warranty_ends_at' => now()->addDays(30)->startOfDay()->addHour(),
        ]);

        // Item expiring in 25 days — outside window
        OrderItem::create([
            'order_id' => $order->id,
            'product_name' => 'Miss Battery',
            'product_sku' => 'MISS',
            'quantity' => 1,
            'price' => 5000,
            'subtotal' => 5000, 'total' => 5000,
            'warranty_months' => 24,
            'warranty_ends_at' => now()->addDays(25),
        ]);

        $this->artisan('vbs:send-warranty-reminders --days=30')
            ->expectsOutputToContain('Sent 1')
            ->assertSuccessful();

        Notification::assertSentTo($user, WarrantyExpiringNotification::class);
    }

    public function test_command_is_idempotent(): void
    {
        $user = $this->makeCustomer();
        $order = $this->makeOrder($user);
        OrderItem::create([
            'order_id' => $order->id,
            'product_name' => 'Battery',
            'product_sku' => 'B',
            'quantity' => 1, 'price' => 5000,
            'subtotal' => 5000, 'total' => 5000,
            'warranty_months' => 24,
            'warranty_ends_at' => now()->addDays(30)->startOfDay()->addHour(),
        ]);

        $this->artisan('vbs:send-warranty-reminders --days=30')->assertSuccessful();
        // Second run shouldn't re-notify (database notifications dedupe via order_item_id)
        $this->artisan('vbs:send-warranty-reminders --days=30')
            ->expectsOutputToContain('Sent 0')
            ->assertSuccessful();
    }
}
