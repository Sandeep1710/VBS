<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantyClaim extends Model
{
    use Auditable;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_RESOLVED = 'resolved';

    public const ISSUE_TYPES = [
        'no_charge' => 'Not holding charge',
        'leaking' => 'Leaking',
        'physical_damage' => 'Physical damage',
        'noise' => 'Unusual noise / sparking',
        'performance' => 'Poor cranking / performance',
        'other' => 'Other',
    ];

    public const RESOLUTIONS = [
        'replaced' => 'Replaced under warranty',
        'repaired' => 'Repaired',
        'partial_credit' => 'Partial credit issued',
        'rejected_out_of_scope' => 'Rejected — out of scope',
        'rejected_user_damage' => 'Rejected — user-caused damage',
    ];

    protected $fillable = [
        'order_id', 'order_item_id', 'user_id',
        'issue_type', 'description', 'status',
        'admin_notes', 'reviewed_by', 'reviewed_at',
        'resolved_at', 'resolution',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'resolved_at' => 'datetime',
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
