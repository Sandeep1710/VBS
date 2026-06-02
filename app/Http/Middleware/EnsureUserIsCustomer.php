<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->status !== 'active') {
            auth()->logout();
            $request->session()->invalidate();
            return redirect()->route('login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
