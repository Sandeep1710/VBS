<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin() || $user->status !== 'active') {
            return redirect()->route('admin.login')
                ->with('error', 'Please sign in with an admin account to continue.');
        }

        return $next($request);
    }
}
