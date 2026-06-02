<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'label', 'name', 'phone',
        'line1', 'line2', 'landmark',
        'city', 'state', 'pincode', 'country',
        'is_default',
    ];

    protected $casts = ['is_default' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->line1, $this->line2, $this->landmark,
            $this->city, $this->state, $this->pincode, $this->country,
        ])->filter()->implode(', ');
    }
}
