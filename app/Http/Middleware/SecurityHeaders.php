<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sensible default security headers. Tweak the CSP if you add
 * additional CDNs/scripts.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip CSP for non-HTML responses (avoids breaking CSV downloads, JSON, etc.)
        $contentType = (string) $response->headers->get('Content-Type');
        $isHtml = str_contains($contentType, 'text/html') || $contentType === '';

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        if ($isHtml) {
            $response->headers->set('Content-Security-Policy', $this->csp());
        }

        return $response;
    }

    private function csp(): string
    {
        $directives = [
            "default-src 'self'",
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://checkout.razorpay.com https://cdn.jsdelivr.net https://cdn.datatables.net https://cdn.ckeditor.com",
            "script-src 'self' 'unsafe-inline' https://checkout.razorpay.com https://js.stripe.com https://cdn.jsdelivr.net https://cdn.datatables.net https://cdn.ckeditor.com https://code.jquery.com https://www.googletagmanager.com https://www.google-analytics.com https://connect.facebook.net",
            "img-src 'self' data: blob: https:",
            "font-src 'self' data: https://fonts.bunny.net https://cdn.jsdelivr.net https://cdn.ckeditor.com",
            "connect-src 'self' https://api.razorpay.com https://lumberjack.razorpay.com https://api.stripe.com https://www.google-analytics.com https://region1.google-analytics.com",
            "frame-src https://api.razorpay.com https://js.stripe.com https://hooks.stripe.com https://www.google.com https://www.googletagmanager.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self' https://checkout.razorpay.com",
        ];
        return implode('; ', $directives);
    }
}
