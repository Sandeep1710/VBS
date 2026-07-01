@props(['size' => 'md'])

@php
    $sizeClass = match($size) {
        'sm' => 'text-base',
        'lg' => 'text-2xl',
        default => 'text-lg',
    };
@endphp

<a href="{{ url('/') }}" {{ $attributes->merge(['class' => "inline-flex items-center gap-2 font-display font-bold $sizeClass text-ink-900"]) }}>
    <span class="grid h-8 w-8 place-items-center rounded-md bg-brand-600 text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 4h10a1 1 0 0 1 1 1v1h1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1V5a1 1 0 0 1 1-1Zm1 2v0Zm-1 6h3v-2H7v2Zm7 0h3v-2h-3v2Z"/>
        </svg>
    </span>
    <span>Trikuti Battery</span>
</a>
