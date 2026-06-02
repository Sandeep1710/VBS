<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'exchange_discount' => (float) $this->exchange_discount,
            'delivery_charge' => (float) $this->delivery_charge,
            'tax_amount' => (float) $this->tax_amount,
            'total' => (float) $this->total,
            'currency' => 'INR',
            'coupon_code' => $this->coupon_code,
            'exchange_pickup_required' => (bool) $this->exchange_pickup_required,
            'cancellable' => $this->isCancellable(),
            'shipping' => [
                'name' => $this->shipping_name,
                'phone' => $this->shipping_phone,
                'line1' => $this->shipping_line1,
                'line2' => $this->shipping_line2,
                'landmark' => $this->shipping_landmark,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'pincode' => $this->shipping_pincode,
                'country' => $this->shipping_country,
            ],
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'items_count' => (int) ($this->relationLoaded('items') ? $this->items->sum('quantity') : 0),
            'timestamps' => [
                'placed_at' => $this->created_at?->toIso8601String(),
                'confirmed_at' => $this->confirmed_at?->toIso8601String(),
                'dispatched_at' => $this->dispatched_at?->toIso8601String(),
                'delivered_at' => $this->delivered_at?->toIso8601String(),
                'completed_at' => $this->completed_at?->toIso8601String(),
                'cancelled_at' => $this->cancelled_at?->toIso8601String(),
            ],
        ];
    }
}
