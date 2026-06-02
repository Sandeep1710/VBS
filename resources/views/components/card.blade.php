@props(['title' => null, 'padding' => 'p-6'])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title)
        <div class="border-b border-ink-200/60 px-6 py-4">
            <h3 class="text-base font-semibold text-ink-900">{{ $title }}</h3>
        </div>
    @endif
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
