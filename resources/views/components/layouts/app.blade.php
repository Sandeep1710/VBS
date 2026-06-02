<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('layouts.partials.head')
</head>
<body class="flex min-h-full flex-col">
    @include('layouts.partials.navbar')

    <main class="flex-1">
        <div class="container-page py-8">
            <x-flash />
            {{ $slot }}
        </div>
    </main>

    @include('layouts.partials.footer')
</body>
</html>
