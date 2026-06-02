<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BatteryBrand extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'description',
        'is_featured', 'is_active', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
