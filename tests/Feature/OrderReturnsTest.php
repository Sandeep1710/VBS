<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\WarrantyClaim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderReturnsTest extends TestCase
{
    use RefreshDatabase;

    private function makeDeliveredOrderWithItem($user, array $itemOverrides = []): array
    {
        $order = Order::create([
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

        $item = OrderItem::create(array_merge([
            'order_id' => $order->id,
            'product_name' => 'Test Battery',
            'product_sku' => 'SKU',
            'quantity' => 2,
            'price' => 2500,
            'subtotal' => 5000,
            'total' => 5000,
            'warranty_months' => 24,
            'warranty_starts_at' => now()->subDay(),
            'warranty_ends_at' => now()->addYears(2),
        ], $itemOverrides));

        return [$order, $item];
    }

    public function test_customer_can_submit_return_request(): void
    {
        $user = $this->makeCustomer();
        [$order, $item] = $this->makeDeliveredOrderWithItem($user);

        $this->actingAs($user)
            ->post(route('account.returns.store', $order), [
                'order_item_id' => $item->id,
                'quantity' => 1,
                'reason' => 'defective',
                'details' => 'Battery dead within a week.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('order_returns', [
            'order_id' => $order->id,
            'order_item_id' => $item->id,
            'reason' => 'defective',
            'status' => OrderReturn::STATUS_REQUESTED,
        ]);
    }

    public function test_return_quantity_cannot_exceed_ordered(): void
    {
        $user = $this->makeCustomer();
        [$order, $item] = $this->makeDeliveredOrderWithItem($user);

        $this->actingAs($user)
            ->from(route('account.returns.create', $order))
            ->post(route('account.returns.store', $order), [
                'order_item_id' => $item->id,
                'quantity' => 99,
                'reason' => 'defective',
            ])
            ->assertSessionHasErrors('quantity');
    }

    public function test_customer_cannot_return_pending_order(): void
    {
        $user = $this->makeCustomer();
        [$order] = $this->makeDeliveredOrderWithItem($user);
        $order->forceFill(['status' => Order::STATUS_PENDING])->save();

        $this->actingAs($user)
            ->get(route('account.returns.create', $order))
            ->assertStatus(422);
    }

    public function test_customer_can_submit_warranty_claim(): void
    {
        $user = $this->makeCustomer();
        [$order, $item] = $this->makeDeliveredOrderWithItem($user);

        $this->actingAs($user)
            ->post(route('account.warranty-claims.store', $order), [
                'order_item_id' => $item->id,
                'issue_type' => 'no_charge',
                'description' => 'Battery does not hold a charge anymore, dies overnight.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('warranty_claims', [
            'order_id' => $order->id,
            'issue_type' => 'no_charge',
            'status' => WarrantyClaim::STATUS_SUBMITTED,
        ]);
    }

    public function test_warranty_claim_rejected_when_warranty_expired(): void
    {
        $user = $this->makeCustomer();
        [$order, $item] = $this->makeDeliveredOrderWithItem($user, [
            'warranty_ends_at' => now()->subMonth(),
        ]);

        $this->actingAs($user)
            ->from(route('account.warranty-claims.create', $order))
            ->post(route('account.warranty-claims.store', $order), [
                'order_item_id' => $item->id,
                'issue_type' => 'no_charge',
                'description' => 'It died but warranty is over.',
            ])
            ->assertSessionHasErrors('order_item_id');
    }

}
