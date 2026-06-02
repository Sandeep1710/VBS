@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    $base = 'btn';
    $variantClass = match ($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        'danger' => 'btn-danger',
        default => 'btn-primary',
    };
    $sizeClass = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3 text-base',
        default => '',
    };
    $classes = trim("$base $variantClass $sizeClass");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
