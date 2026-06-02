<x-layouts.admin :title="'Pages'" :header="'Manage pages'">
    <p class="text-sm text-ink-600">Edit the content that appears on the public About Us and Contact Us pages.</p>

    {{-- Tab nav --}}
    <div class="mt-6 border-b border-ink-200">
        <nav class="flex gap-1" aria-label="Tabs">
            @foreach([
                ['slug' => 'about-us', 'label' => 'About Us'],
                ['slug' => 'contact-us', 'label' => 'Contact Us'],
            ] as $tab)
                @php $isActive = $activeTab === $tab['slug']; @endphp
                <button type="button"
                        data-tab-trigger="{{ $tab['slug'] }}"
                        class="-mb-px border-b-2 px-4 py-2.5 text-sm font-medium transition-colors {{ $isActive ? 'border-brand-600 text-brand-700' : 'border-transparent text-ink-600 hover:text-ink-900' }}">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </nav>
    </div>

    {{-- About Us panel --}}
    <div data-tab-panel="about-us" class="{{ $activeTab === 'about-us' ? '' : 'hidden' }}">
        @include('admin.pages._form', [
            'page' => $about,
            'slug' => 'about-us',
            'label' => 'About Us',
            'placeholder' => '<p>Tell visitors who you are, what you sell, and why they should trust you.</p>',
            'previewUrl' => url('/cms/about-us'),
        ])
    </div>

    {{-- Contact Us panel --}}
    <div data-tab-panel="contact-us" class="{{ $activeTab === 'contact-us' ? '' : 'hidden' }}">
        @include('admin.pages._form', [
            'page' => $contact,
            'slug' => 'contact-us',
            'label' => 'Contact Us',
            'placeholder' => '<p>Phone: <strong>1800-XXX-XXXX</strong></p><p>Email: <a href=&quot;mailto:hello@example.com&quot;>hello@example.com</a></p><p>Address: 123 Battery Street, City</p>',
            'previewUrl' => url('/cms/contact-us'),
        ])
    </div>

    <script>
        (function () {
            const triggers = document.querySelectorAll('[data-tab-trigger]');
            const panels = document.querySelectorAll('[data-tab-panel]');

            triggers.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-tab-trigger');

                    triggers.forEach((t) => {
                        const active = t.getAttribute('data-tab-trigger') === target;
                        t.classList.toggle('border-brand-600', active);
                        t.classList.toggle('text-brand-700', active);
                        t.classList.toggle('border-transparent', !active);
                        t.classList.toggle('text-ink-600', !active);
                    });

                    panels.forEach((p) => {
                        p.classList.toggle('hidden', p.getAttribute('data-tab-panel') !== target);
                    });

                    const url = new URL(window.location);
                    url.searchParams.set('tab', target);
                    window.history.replaceState({}, '', url);
                });
            });
        })();
    </script>
</x-layouts.admin>
