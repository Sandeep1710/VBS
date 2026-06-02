<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Auditable, SoftDeletes;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_DISPATCHED = 'dispatched';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAY_PENDING = 'pending';
    public const PAY_PAID = 'paid';
    public const PAY_FAILED = 'failed';
    public const PAY_REFUNDED = 'refunded';

    protected $fillable = [
        'order_number', 'user_id', 'status', 'payment_status',
        'billing_name', 'billing_phone', 'billing_email',
        'billing_line1', 'billing_line2', 'billing_city', 'billing_state', 'billing_pincode', 'billing_country',
        'shipping_name', 'shipping_phone',
        'shipping_line1', 'shipping_line2', 'shipping_landmark',
        'shipping_city', 'shipping_state', 'shipping_pincode', 'shipping_country',
        'subtotal', 'discount', 'exchange_discount', 'delivery_charge', 'tax_amount', 'total',
        'coupon_id', 'coupon_code', 'payment_method',
        'exchange_pickup_required',
        'confirmed_at', 'dispatched_at', 'delivered_at', 'completed_at', 'cancelled_at', 'cancellation_reason',
        'notes', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'exchange_discount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'exchange_pickup_required' => 'boolean',
        'confirmed_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class)->orderBy('id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING, self::STATUS_CONFIRMED,
        ], true);
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_DISPATCHED,
            self::STATUS_DELIVERED, self::STATUS_COMPLETED, self::STATUS_CANCELLED,
        ];
    }
}
