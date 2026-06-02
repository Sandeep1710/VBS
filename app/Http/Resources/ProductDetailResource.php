<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProductDetailResource extends ProductResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'description' => $this->description,
            'stock_quantity' => (int) $this->stock_quantity,
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($img) => [
                'id' => $img->id,
                'url' => asset('storage/' . $img->path),
                'alt' => $img->alt,
                'is_primary' => (bool) $img->is_primary,
            ])),
            'specifications' => $this->whenLoaded('specifications', fn () => $this->specifications->map(fn ($s) => [
                'group' => $s->group,
                'key' => $s->key,
                'value' => $s->value,
            ])),
            'compatible_vehicles' => $this->whenLoaded('fitments', fn () => $this->fitments->map(function ($fit) {
                $variant = $fit->vehicleVariant;
                $model = $variant?->vehicleModel;
                if (! $variant || ! $model) {
                    return null;
                }
                return [
                    'variant_id' => $variant->id,
                    'brand' => $model->vehicleBrand?->name,
                    'model' => $model->name,
                    'variant' => $variant->name,
                    'fuel_type' => $variant->fuel_type,
                    'year_from' => $variant->year_from,
                    'year_to' => $variant->year_to,
                ];
            })->filter()->values()),
        ]);
    }
}
