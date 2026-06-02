<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'items_count' => (int) ($this->relationLoaded('items') ? $this->items->sum('quantity') : 0),
            'coupon_code' => $this->coupon_code,
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'exchange_discount' => (float) $this->exchange_discount,
            'delivery_charge' => (float) $this->delivery_charge,
            'tax' => (float) $this->tax,
            'total' => (float) $this->total,
            'currency' => 'INR',
        ];
    }
}
