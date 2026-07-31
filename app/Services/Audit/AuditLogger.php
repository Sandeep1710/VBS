<?php

namespace App\Services\Audit;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Central audit-logger. Persists every event to the audit_logs table AND
 * mirrors a structured line into storage/logs/laravel.log for tail/grep.
 *
 * Usage:
 *   app(AuditLogger::class)->log('order.created', 'Lead placed', $order, ['total' => 5799]);
 */
class AuditLogger
{
    public function log(
        string $event,
        ?string $description = null,
        ?object $subject = null,
        array $metadata = [],
        ?array $oldValues = null,
        ?array $newValues = null,
    ): void {
        try {
            $request = app(Request::class);
            $user = Auth::user();

            $context = [
                'user_id'        => $user?->id,
                'user_type'      => $this->resolveUserType($user),
                'user_email'     => $user?->email,
                'ip'             => $request->ip(),
                'user_agent'     => (string) $request->userAgent(),
                'method'         => $request->method(),
                'url'            => $request->fullUrl(),
                'route'          => optional($request->route())->getName(),
                'subject_type'   => $subject ? $subject::class : null,
                'subject_id'     => $subject?->getKey(),
                'description'    => $description,
                'metadata'       => $metadata,
            ];

            AuditLog::create([
                'user_id'        => $user?->id,
                'event'          => $event,
                'auditable_type' => $subject ? $subject::class : null,
                'auditable_id'   => $subject?->getKey(),
                'old_values'     => $oldValues,
                'new_values'     => $newValues ?? array_filter([
                    'description' => $description,
                    'method'      => $request->method(),
                    'route'       => optional($request->route())->getName(),
                    'metadata'    => $metadata ?: null,
                ], fn ($v) => $v !== null),
                'url'            => substr((string) $request->fullUrl(), 0, 500),
                'ip_address'     => $request->ip(),
                'user_agent'     => substr((string) $request->userAgent(), 0, 500),
            ]);

            Log::channel(config('logging.default'))->info("[audit] {$event}", $context);
        } catch (Throwable $e) {
            // Never break the request because of audit logging
            Log::warning('AuditLogger failed', ['error' => $e->getMessage(), 'event' => $event]);
        }
    }

    private function resolveUserType(?User $user): string
    {
        if (! $user) {
            return 'guest';
        }
        return $user->is_admin ? 'admin' : 'customer';
    }
}
