<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleBrand extends Model
{
    protected $fillable = ['name', 'slug', 'logo', 'is_active', 'sort_order'];

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
