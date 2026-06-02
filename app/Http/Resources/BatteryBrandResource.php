<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatteryBrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'logo_url' => $this->logo ? asset('storage/' . $this->logo) : null,
            'is_featured' => (bool) $this->is_featured,
        ];
    }
}
