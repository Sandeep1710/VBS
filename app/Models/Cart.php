<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'session_token', 'coupon_code',
        'subtotal', 'discount', 'exchange_discount',
        'delivery_charge', 'tax', 'total', 'meta', 'expires_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'expires_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'exchange_discount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getItemsCountAttribute(): int
    {
        return (int) $this->items()->sum('quantity');
    }
}
