<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image', 'mobile_image',
        'link_url', 'link_text', 'position',
        'sort_order', 'is_active', 'starts_at', 'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function scopeActive(Builder $q): Builder
    {
        $now = now();
        return $q->where('is_active', true)
            ->where(fn ($x) => $x->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
            ->where(fn ($x) => $x->whereNull('ends_at')->orWhere('ends_at', '>=', $now));
    }
}
