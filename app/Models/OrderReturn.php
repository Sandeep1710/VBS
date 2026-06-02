<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReturn extends Model
{
    use Auditable;

    public const STATUS_REQUESTED = 'requested';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PICKED_UP = 'picked_up';
    public const STATUS_REFUNDED = 'refunded';

    public const REASONS = [
        'defective' => 'Defective / not working',
        'wrong_item' => 'Wrong item delivered',
        'damaged' => 'Damaged in transit',
        'not_compatible' => 'Not compatible with my vehicle',
        'changed_mind' => 'Changed my mind',
        'other' => 'Other',
    ];

    protected $fillable = [
        'order_id', 'order_item_id', 'user_id',
        'quantity', 'reason', 'details', 'status',
        'admin_notes', 'reviewed_by', 'reviewed_at',
        'refunded_at', 'refund_amount',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'refunded_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
