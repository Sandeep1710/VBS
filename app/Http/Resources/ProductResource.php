<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'capacity_ah' => $this->capacity_ah ? (float) $this->capacity_ah : null,
            'voltage' => $this->voltage ? (float) $this->voltage : null,
            'warranty_months' => (int) $this->warranty_months,
            'price' => (float) $this->price,
            'offer_price' => $this->offer_price ? (float) $this->offer_price : null,
            'effective_price' => (float) $this->effective_price,
            'discount_percent' => $this->discount_percent,
            'currency' => 'INR',
            'short_description' => $this->short_description,
            'exchange_available' => (bool) $this->exchange_available,
            'exchange_discount' => (float) $this->exchange_discount,
            'in_stock' => $this->in_stock,
            'is_featured' => (bool) $this->is_featured,
            'rating_avg' => (float) $this->rating_avg,
            'rating_count' => (int) $this->rating_count,
            'image_url' => $this->primaryImage?->path
                ? asset('storage/' . $this->primaryImage->path)
                : null,
            'brand' => new BatteryBrandResource($this->whenLoaded('batteryBrand')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'url' => route('products.show', $this->resource),
        ];
    }
}
