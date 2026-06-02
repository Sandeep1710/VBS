<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'quantity' => (int) $this->quantity,
            'price' => (float) $this->price,
            'offer_price' => $this->offer_price ? (float) $this->offer_price : null,
            'effective_price' => (float) $this->effective_price,
            'exchange_old_battery' => (bool) $this->exchange_old_battery,
            'exchange_discount' => (float) $this->exchange_discount,
            'line_total' => (float) $this->line_total,
        ];
    }
}
