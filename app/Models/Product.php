<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Auditable, SoftDeletes;

    public function auditExclude(): array
    {
        return ['updated_at', 'views_count', 'sales_count', 'rating_avg', 'rating_count'];
    }

    protected $fillable = [
        'battery_brand_id', 'category_id', 'name', 'slug', 'sku',
        'capacity_ah', 'voltage', 'warranty_months',
        'price', 'offer_price',
        'short_description', 'description',
        'exchange_available', 'exchange_discount',
        'stock_quantity', 'low_stock_threshold',
        'is_featured', 'is_active',
        'views_count', 'sales_count', 'rating_avg', 'rating_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'capacity_ah' => 'decimal:2',
        'voltage' => 'decimal:2',
        'exchange_discount' => 'decimal:2',
        'rating_avg' => 'decimal:2',
        'exchange_available' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function batteryBrand(): BelongsTo
    {
        return $this->belongsTo(BatteryBrand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order');
    }

    public function fitments(): HasMany
    {
        return $this->hasMany(Fitment::class);
    }

    public function wishlistedBy(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function vehicleVariants(): BelongsToMany
    {
        return $this->belongsToMany(VehicleVariant::class, 'fitments')
            ->withPivot(['notes', 'is_recommended'])
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->offer_price ?? $this->price);
    }

    public function getDiscountPercentAttribute(): int
    {
        if (! $this->offer_price || $this->price <= 0) {
            return 0;
        }
        return (int) round((($this->price - $this->offer_price) / $this->price) * 100);
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock_quantity > 0 && $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock_quantity', '>', 0);
    }
}
