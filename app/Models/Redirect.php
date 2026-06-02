<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use Auditable;

    public function auditExclude(): array
    {
        return ['updated_at', 'hits', 'last_hit_at'];
    }

    protected $fillable = [
        'from_path', 'to_path', 'status_code', 'is_active', 'notes',
        'hits', 'last_hit_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_hit_at' => 'datetime',
    ];
}
