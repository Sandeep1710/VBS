@php
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $tagline = \App\Models\Setting::get('site_tagline', '');
    $email = \App\Models\Setting::get('support_email');
    $phone = \App\Models\Setting::get('support_phone');
    $address = \App\Models\Setting::get('address');
    $facebook = \App\Models\Setting::get('facebook', null, 'social');
    $instagram = \App\Models\Setting::get('instagram', null, 'social');
    $footerPages = \App\Models\CmsPage::where('show_in_footer', true)->where('is_active', true)->orderBy('sort_order')->get();
@endphp

<footer class="mt-16 border-t border-ink-200/60 bg-white">
    <div class="container-page py-12">
        <div class="grid gap-8 md:grid-cols-4">
            <div class="md:col-span-2">
                <x-logo size="lg" />
                <p class="mt-3 max-w-md text-sm text-ink-600">{{ $tagline }}</p>
                @if($address)
                    <p class="mt-4 text-sm text-ink-600">{{ $address }}</p>
                @endif
                <form method="POST" action="{{ route('newsletter.subscribe') }}" class="mt-4 flex max-w-sm gap-2">
                    @csrf
                    <input type="email" name="email" required placeholder="Your email" class="input flex-1">
                    <button class="btn btn-primary text-xs">Subscribe</button>
                </form>
                <p class="mt-1 text-xs text-ink-500">Get offers and battery tips. No spam.</p>

                <div class="mt-4 flex items-center gap-3">
                    @if($facebook)
                        <a href="{{ $facebook }}" target="_blank" rel="noopener" class="grid h-9 w-9 place-items-center rounded-full bg-ink-100 text-ink-700 hover:bg-brand-100 hover:text-brand-700">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H8v-3h2.4V9.9c0-2.4 1.4-3.7 3.6-3.7 1 0 2.1.2 2.1.2v2.3h-1.2c-1.2 0-1.5.7-1.5 1.5V12h2.6l-.4 3h-2.2v7A10 10 0 0 0 22 12Z"/></svg>
                        </a>
                    @endif
                    @if($instagram)
                        <a href="{{ $instagram }}" target="_blank" rel="noopener" class="grid h-9 w-9 place-items-center rounded-full bg-ink-100 text-ink-700 hover:bg-brand-100 hover:text-brand-700">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4 1 .5.4.8.8 1 1.4.1.4.3 1 .4 2.2.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-1 1.4-.4.5-.8.8-1.4 1-.4.1-1 .3-2.2.4-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-1.8-.3-2.2-.4-.6-.2-1-.5-1.4-1-.5-.4-.8-.8-1-1.4-.1-.4-.3-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c.1-1.2.3-1.8.4-2.2.2-.6.5-1 1-1.4.4-.5.8-.8 1.4-1 .4-.1 1-.3 2.2-.4C8.4 2.2 8.8 2.2 12 2.2Zm0 2c-3.1 0-3.5 0-4.7.1-1.1 0-1.7.2-2.1.3-.5.2-.9.4-1.3.8-.4.4-.6.8-.8 1.3-.1.4-.3 1-.3 2.1-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c0 1.1.2 1.7.3 2.1.2.5.4.9.8 1.3.4.4.8.6 1.3.8.4.1 1 .3 2.1.3 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1.1 0 1.7-.2 2.1-.3.5-.2.9-.4 1.3-.8.4-.4.6-.8.8-1.3.1-.4.3-1 .3-2.1.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c0-1.1-.2-1.7-.3-2.1-.2-.5-.4-.9-.8-1.3-.4-.4-.8-.6-1.3-.8-.4-.1-1-.3-2.1-.3-1.2-.1-1.6-.1-4.7-.1ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.4-3.4a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4Z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-ink-900">Shop</h4>
                <ul class="mt-3 space-y-2 text-sm text-ink-600">
                    <li><a href="{{ url('/products') }}" class="hover:text-brand-600">All Batteries</a></li>
                    <li><a href="{{ url('/categories/car-batteries') }}" class="hover:text-brand-600">Car Batteries</a></li>
                    <li><a href="{{ url('/categories/bike-batteries') }}" class="hover:text-brand-600">Bike Batteries</a></li>
                    <li><a href="{{ url('/finder') }}" class="hover:text-brand-600">Find My Battery</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-ink-900">Help</h4>
                <ul class="mt-3 space-y-2 text-sm text-ink-600">
                    @foreach($footerPages as $page)
                        <li><a href="{{ url('/cms/' . $page->slug) }}" class="hover:text-brand-600">{{ $page->title }}</a></li>
                    @endforeach
                    @if($email)
                        <li class="pt-2"><a href="mailto:{{ $email }}" class="hover:text-brand-600">{{ $email }}</a></li>
                    @endif
                    @if($phone)
                        <li><a href="tel:{{ $phone }}" class="hover:text-brand-600">{{ $phone }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col items-center justify-between gap-3 border-t border-ink-200/60 pt-6 text-xs text-ink-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
            <p>Built with care for vehicle owners across India.</p>
        </div>
    </div>
</footer>
