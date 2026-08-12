@php
    $messages = array_filter([
        'success' => session('success'),
        'error' => session('error'),
        'warning' => session('warning'),
        'info' => session('info') ?? session('status'),
    ]);
@endphp

@if($messages)
    {{-- Fixed overlay so the message is seen wherever the user is scrolled to.
         Add-to-cart redirects back to the form, which can sit far below the fold. --}}
    <div class="pointer-events-none fixed inset-x-0 top-20 z-50 flex flex-col items-center gap-2 px-4">
        @foreach($messages as $type => $message)
            @php
                $classes = match($type) {
                    'success' => 'bg-green-50 text-green-800 ring-green-200',
                    'error' => 'bg-red-50 text-red-800 ring-red-200',
                    'warning' => 'bg-amber-50 text-amber-800 ring-amber-200',
                    default => 'bg-blue-50 text-blue-800 ring-blue-200',
                };
            @endphp
            <div data-flash
                 role="status"
                 class="pointer-events-auto w-full max-w-sm rounded-lg px-4 py-3 text-sm font-medium shadow-lg ring-1 transition-opacity duration-500 {{ $classes }}">
                {{ $message }}
            </div>
        @endforeach
    </div>
@endif
