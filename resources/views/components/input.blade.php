@props([
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'autocomplete' => null,
])

@php
    $hasError = $errors->has($name);
    $val = old($name, $value);
@endphp

<input
    {{ $attributes->merge(['class' => 'input ' . ($hasError ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '')]) }}
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $attributes->get('id', $name) }}"
    value="{{ $type === 'password' ? '' : $val }}"
    placeholder="{{ $placeholder }}"
    @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    @if($required) required @endif
/>
