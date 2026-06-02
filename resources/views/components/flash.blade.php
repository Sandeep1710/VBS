@php
    $messages = [
        'success' => session('success'),
        'error' => session('error'),
        'warning' => session('warning'),
        'info' => session('info') ?? session('status'),
    ];
@endphp

@foreach($messages as $type => $message)
    @if($message)
        @php
            $classes = match($type) {
                'success' => 'bg-green-50 text-green-800 ring-green-200',
                'error' => 'bg-red-50 text-red-800 ring-red-200',
                'warning' => 'bg-amber-50 text-amber-800 ring-amber-200',
                default => 'bg-blue-50 text-blue-800 ring-blue-200',
            };
        @endphp
        <div data-flash class="mb-4 rounded-lg px-4 py-3 ring-1 transition-opacity duration-500 {{ $classes }}">
            {{ $message }}
        </div>
    @endif
@endforeach
