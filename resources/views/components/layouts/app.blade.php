<!DOCTYPE html>
<html lang="en-IN" class="h-full">
<head>
    @include('layouts.partials.head')
</head>
<body class="flex min-h-full flex-col">
    @php $gtmId = trim((string) \App\Models\Setting::get('google_tag_manager_id', '', 'seo')); @endphp
    @if($gtmId)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
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
