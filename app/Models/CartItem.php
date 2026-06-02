<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', 'product_id', 'quantity',
        'price', 'offer_price',
        'exchange_old_battery', 'exchange_discount',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'exchange_discount' => 'decimal:2',
        'exchange_old_battery' => 'boolean',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->offer_price ?? $this->price);
    }

    public function getLineTotalAttribute(): float
    {
        $base = $this->effective_price * $this->quantity;
        $exchange = $this->exchange_old_battery ? $this->exchange_discount * $this->quantity : 0;
        return (float) max(0, $base - $exchange);
    }
}
