<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_sku' => $this->product_sku,
            'product_brand' => $this->product_brand,
            'product_image' => $this->product_image ? asset('storage/' . $this->product_image) : null,
            'quantity' => (int) $this->quantity,
            'price' => (float) $this->price,
            'offer_price' => $this->offer_price ? (float) $this->offer_price : null,
            'exchange_old_battery' => (bool) $this->exchange_old_battery,
            'exchange_discount' => (float) $this->exchange_discount,
            'subtotal' => (float) $this->subtotal,
            'total' => (float) $this->total,
            'warranty_months' => (int) $this->warranty_months,
            'warranty_starts_at' => $this->warranty_starts_at?->format('Y-m-d'),
            'warranty_ends_at' => $this->warranty_ends_at?->format('Y-m-d'),
        ];
    }
}
