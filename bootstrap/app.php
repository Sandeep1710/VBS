<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'customer' => \App\Http\Middleware\EnsureUserIsCustomer::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        $middleware->preventRequestForgery(except: [
            'webhooks/*',
        ]);

        $middleware->redirectGuestsTo(fn (Request $request) => $request->expectsJson() ? null : route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
