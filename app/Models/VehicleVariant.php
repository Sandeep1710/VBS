<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VehicleVariant extends Model
{
    protected $fillable = [
        'vehicle_model_id', 'name', 'fuel_type',
        'year_from', 'year_to', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'fitments')
            ->withPivot(['notes', 'is_recommended'])
            ->withTimestamps();
    }
}
