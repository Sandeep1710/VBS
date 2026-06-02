<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'name', 'is_active', 'source', 'unsubscribed_at', 'unsubscribe_token'];

    protected $casts = [
        'is_active' => 'boolean',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $sub) {
            if (! $sub->unsubscribe_token) {
                $sub->unsubscribe_token = Str::random(40);
            }
        });
    }
}
