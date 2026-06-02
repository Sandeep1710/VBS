<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleType extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function vehicleModels(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
