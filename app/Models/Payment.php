<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public const STATUS_INITIATED = 'initiated';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'order_id', 'user_id', 'gateway',
        'gateway_order_id', 'gateway_payment_id', 'gateway_signature',
        'amount', 'currency', 'status', 'method',
        'response', 'error_message', 'paid_at',
    ];

    protected $casts = [
        'response' => 'array',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected $hidden = ['gateway_signature'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
