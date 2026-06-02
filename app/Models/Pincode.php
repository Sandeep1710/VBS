<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = [
        'pincode', 'city', 'state', 'region',
        'is_serviceable', 'cod_available',
        'delivery_charge', 'expected_delivery_days',
    ];

    protected $casts = [
        'is_serviceable' => 'boolean',
        'cod_available' => 'boolean',
        'delivery_charge' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'pincode';
    }
}
