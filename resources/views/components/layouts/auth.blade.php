<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('layouts.partials.head')
</head>
<body class="min-h-full bg-gradient-to-br from-ink-50 to-ink-100">
    <div class="flex min-h-screen flex-col">
        <header class="container-page py-6">
            <x-logo size="md" />
        </header>

        <main class="flex flex-1 items-center justify-center px-4 pb-10">
            <div class="w-full max-w-md">
                <x-flash />
                {{ $slot }}
            </div>
        </main>

        <footer class="container-page py-6 text-center text-xs text-ink-500">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', config('app.name')) }}. All rights reserved.
        </footer>
    </div>
</body>
</html>
