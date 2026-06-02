<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id',
        'product_name', 'product_sku', 'product_brand', 'product_image',
        'quantity', 'price', 'offer_price',
        'exchange_old_battery', 'exchange_discount',
        'subtotal', 'total',
        'warranty_months', 'warranty_starts_at', 'warranty_ends_at',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'exchange_discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'exchange_old_battery' => 'boolean',
        'warranty_starts_at' => 'date',
        'warranty_ends_at' => 'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
