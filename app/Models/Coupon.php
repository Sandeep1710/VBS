<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use Auditable;

    public function auditExclude(): array
    {
        return ['updated_at', 'used_count'];
    }

    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_FLAT = 'flat';

    protected $fillable = [
        'code', 'name', 'description', 'type', 'value',
        'max_discount', 'min_order_amount',
        'usage_limit', 'per_user_limit', 'used_count',
        'starts_at', 'expires_at',
        'is_active', 'is_first_order_only',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'is_first_order_only' => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }
        return true;
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }
}
