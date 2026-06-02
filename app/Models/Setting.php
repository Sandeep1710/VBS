<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'label', 'is_public'];

    protected $casts = ['is_public' => 'boolean'];

    public static function get(string $key, mixed $default = null, string $group = 'general'): mixed
    {
        return Cache::rememberForever("setting:$group:$key", function () use ($key, $default, $group) {
            $row = static::where('group', $group)->where('key', $key)->first();
            if (! $row) {
                return $default;
            }
            return match ($row->type) {
                'integer' => (int) $row->value,
                'boolean' => filter_var($row->value, FILTER_VALIDATE_BOOLEAN),
                'json' => json_decode($row->value, true),
                default => $row->value,
            };
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'string'): self
    {
        $stored = is_array($value) ? json_encode($value) : (string) $value;
        $row = static::updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => $stored, 'type' => $type],
        );
        Cache::forget("setting:$group:$key");
        return $row;
    }

    protected static function booted(): void
    {
        static::saved(fn (self $m) => Cache::forget("setting:{$m->group}:{$m->key}"));
        static::deleted(fn (self $m) => Cache::forget("setting:{$m->group}:{$m->key}"));
    }
}
