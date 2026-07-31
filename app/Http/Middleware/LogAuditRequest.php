<?php

namespace App\Http\Middleware;

use App\Services\Audit\AuditLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Logs every state-changing HTTP request (POST/PATCH/PUT/DELETE) plus admin
 * page views to the audit log. GET requests to non-admin pages are ignored
 * to keep the table lean — enable via `?audit=1` query param if you want
 * to trace a specific customer flow.
 */
class LogAuditRequest
{
    /** Routes we never audit (too noisy). */
    private const IGNORED_ROUTES = [
        'delivery.check',   // fires on every keystroke
        'sitemap',
        'robots',
    ];

    public function __construct(private readonly AuditLogger $logger)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            if ($this->shouldLog($request)) {
                $routeName = optional($request->route())->getName();
                $event = $this->deriveEvent($request, $routeName);

                $this->logger->log(
                    event: $event,
                    description: $this->describe($request, $routeName),
                    metadata: [
                        'status' => $response->getStatusCode(),
                    ],
                );
            }
        } catch (\Throwable $e) {
            // Never crash the request because of logging
        }

        return $response;
    }

    private function shouldLog(Request $request): bool
    {
        $routeName = optional($request->route())->getName();

        if ($routeName && in_array($routeName, self::IGNORED_ROUTES, true)) {
            return false;
        }

        // Always log state-changing requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return true;
        }

        // Log admin GETs (page views) so we can trace admin activity
        if ($request->is('admin') || $request->is('admin/*')) {
            return true;
        }

        // Opt-in tracing via ?audit=1 for debugging customer flows
        return $request->boolean('audit');
    }

    private function deriveEvent(Request $request, ?string $routeName): string
    {
        $method = strtolower($request->method());

        if ($routeName) {
            return "request.{$method}.{$routeName}";
        }

        return "request.{$method}";
    }

    private function describe(Request $request, ?string $routeName): string
    {
        return sprintf('%s %s%s',
            $request->method(),
            $request->path(),
            $routeName ? " ({$routeName})" : '',
        );
    }
}
