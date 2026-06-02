<?php

namespace App\Models\Concerns;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Auditable
{
    /**
     * Override per-model to limit which attributes are audited.
     * Default: all attributes except those in $hidden / $auditExclude.
     *
     * @return array<int, string>
     */
    public function auditExclude(): array
    {
        return [
            'updated_at', 'remember_token', 'password',
        ];
    }

    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public static function bootAuditable(): void
    {
        static::created(fn (Model $model) => self::recordAudit($model, 'created'));
        static::updated(fn (Model $model) => self::recordAudit($model, 'updated'));
        static::deleted(fn (Model $model) => self::recordAudit($model, 'deleted'));
    }

    protected static function recordAudit(Model $model, string $event): void
    {
        $exclude = method_exists($model, 'auditExclude') ? $model->auditExclude() : [];

        $newValues = collect($model->getAttributes())
            ->except($exclude)
            ->all();

        $oldValues = match ($event) {
            'updated' => collect($model->getOriginal())
                ->except($exclude)
                ->only(array_keys($model->getDirty()))
                ->all(),
            'deleted' => $newValues,
            default => null,
        };

        if ($event === 'updated') {
            $newValues = collect($newValues)->only(array_keys($model->getDirty()))->all();
            if (empty($newValues)) {
                return;
            }
        }

        AuditLog::create([
            'user_id' => optional(auth()->user())->id,
            'event' => $event,
            'auditable_type' => $model::class,
            'auditable_id' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $event === 'deleted' ? null : $newValues,
            'url' => optional(request())->fullUrl(),
            'ip_address' => optional(request())->ip(),
            'user_agent' => optional(request())->userAgent(),
        ]);
    }
}
