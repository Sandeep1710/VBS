<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

/**
 * Looks up the current URI in the `redirects` table and issues a 301/302
 * if a match is found. Cached for 60 seconds to avoid hammering DB on
 * every request.
 */
class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only redirect on GET / HEAD — otherwise we'd swallow form posts.
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        // Skip if redirects table doesn't exist yet (avoid bootstrap errors during migrate)
        if (! Cache::remember('redirects:table_exists', 600, fn () => Schema::hasTable('redirects'))) {
            return $next($request);
        }

        $path = '/' . ltrim($request->path(), '/');

        $rules = Cache::remember('redirects:active', 60, function () {
            return Redirect::where('is_active', true)
                ->select('id', 'from_path', 'to_path', 'status_code')
                ->get()
                ->keyBy('from_path');
        });

        $rule = $rules[$path] ?? null;
        if (! $rule) {
            return $next($request);
        }

        // Best-effort hit counter (don't block on errors)
        try {
            Redirect::where('id', $rule->id)->update([
                'hits' => \DB::raw('hits + 1'),
                'last_hit_at' => now(),
            ]);
        } catch (\Throwable) {
            // ignore
        }

        return redirect($rule->to_path, $rule->status_code);
    }
}
