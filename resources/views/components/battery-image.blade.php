@props(['product', 'alt' => null])

@php
    $alt = $alt ?? $product->name;

    if ($product->primaryImage?->path && ! str_ends_with($product->primaryImage->path, 'placeholder.svg')) {
        $src = asset('storage/' . $product->primaryImage->path);
    } else {
        $slug = $product->category?->slug;
        $file = match ($slug) {
            'bike-batteries' => 'bike-battery.svg',
            'car-batteries' => 'car-battery.svg',
            default => 'generic-battery.svg',
        };
        $src = asset('images/batteries/' . $file);
    }
@endphp

<img src="{{ $src }}" alt="{{ $alt }}" loading="lazy" {{ $attributes->merge(['class' => 'h-full w-full object-contain']) }}>
