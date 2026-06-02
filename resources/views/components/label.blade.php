@props(['for' => null, 'value' => null, 'required' => false])

<label for="{{ $for }}" {{ $attributes->merge(['class' => 'label']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-brand-600">*</span>
    @endif
</label>
