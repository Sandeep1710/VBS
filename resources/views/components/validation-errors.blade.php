@if($errors->any() && ! $errors->getBag('default'))
    @php $errors = $errors->getBag('default'); @endphp
@endif

@if($errors && $errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4 rounded-lg bg-red-50 px-4 py-3 ring-1 ring-red-200']) }}>
        <p class="text-sm font-semibold text-red-800">{{ __('Please fix the following:') }}</p>
        <ul class="mt-1 list-inside list-disc text-sm text-red-700">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
