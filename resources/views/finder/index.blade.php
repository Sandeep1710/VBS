<x-layouts.app :title="'Find My Battery | Trikuti Battery'">
    <div class="mx-auto max-w-3xl">
        <div class="text-center">
            <span class="badge bg-brand-100 text-brand-700">Battery finder</span>
            <h1 class="mt-3 text-3xl font-bold text-ink-900 sm:text-4xl">Find the right battery for your vehicle</h1>
            <p class="mt-2 text-base text-ink-600">Tell us about your car or bike and we'll show batteries guaranteed to fit.</p>
        </div>

        <x-card class="mt-8">
            <form id="finder-form" method="POST" action="{{ route('finder.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <x-label value="1. Vehicle type" required />
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-{{ min(4, $types->count()) }}">
                        @foreach($types as $type)
                            <label class="cursor-pointer">
                                <input type="radio" name="vehicle_type_id" value="{{ $type->id }}" class="peer sr-only" data-type-radio>
                                <div class="grid h-20 place-items-center rounded-lg border border-ink-200 bg-white text-sm font-medium text-ink-700 transition-colors peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-800">
                                    {{ $type->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div data-step="brand" class="hidden">
                    <x-label for="vehicle_brand_id" value="2. Brand" required />
                    <select name="vehicle_brand_id" id="vehicle_brand_id" class="input">
                        <option value="">Select brand</option>
                    </select>
                </div>

                <div data-step="model" class="hidden">
                    <x-label for="vehicle_model_id" value="3. Model" required />
                    <select name="vehicle_model_id" id="vehicle_model_id" class="input">
                        <option value="">Select model</option>
                    </select>
                </div>

                <div data-step="variant" class="hidden">
                    <x-label for="vehicle_variant_id" value="4. Variant / Year" required />
                    <select name="vehicle_variant_id" id="vehicle_variant_id" class="input" required>
                        <option value="">Select variant</option>
                    </select>
                </div>

                <button type="submit" id="finder-submit" disabled class="btn btn-primary w-full">Show compatible batteries</button>
            </form>
        </x-card>

        <div class="mt-6 grid grid-cols-3 gap-3 text-center text-xs">
            @foreach([
                ['Brand-fit guarantee', 'Compatible with your exact model'],
                ['Free delivery', 'Doorstep delivery'],
                ['Old battery exchange', 'Get instant exchange value'],
            ] as [$title, $desc])
                <div class="card p-3">
                    <p class="text-sm font-semibold text-ink-900">{{ $title }}</p>
                    <p class="text-xs text-ink-500">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>

    @push('head')
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('finder-form');
            const brandSelect = form.querySelector('#vehicle_brand_id');
            const modelSelect = form.querySelector('#vehicle_model_id');
            const variantSelect = form.querySelector('#vehicle_variant_id');
            const submit = form.querySelector('#finder-submit');
            const steps = {
                brand: form.querySelector('[data-step="brand"]'),
                model: form.querySelector('[data-step="model"]'),
                variant: form.querySelector('[data-step="variant"]'),
            };

            const fillSelect = (select, items, labelFn = (i) => i.name) => {
                select.innerHTML = '<option value="">Select</option>';
                items.forEach(it => {
                    const opt = document.createElement('option');
                    opt.value = it.id;
                    opt.textContent = labelFn(it);
                    select.appendChild(opt);
                });
            };

            const reset = (...keys) => {
                keys.forEach(k => {
                    if (steps[k]) steps[k].classList.add('hidden');
                    const sel = form.querySelector(`#vehicle_${k}_id`);
                    if (sel) sel.innerHTML = '<option value="">Select</option>';
                });
                submit.disabled = true;
            };

            form.querySelectorAll('[data-type-radio]').forEach(r => {
                r.addEventListener('change', async () => {
                    reset('brand', 'model', 'variant');
                    const res = await fetch(`{{ route('finder.brands') }}?type=${r.value}`);
                    const data = await res.json();
                    fillSelect(brandSelect, data);
                    steps.brand.classList.remove('hidden');
                });
            });

            brandSelect.addEventListener('change', async () => {
                reset('model', 'variant');
                if (!brandSelect.value) return;
                const type = form.querySelector('[data-type-radio]:checked')?.value;
                const res = await fetch(`{{ route('finder.models') }}?type=${type}&brand=${brandSelect.value}`);
                const data = await res.json();
                fillSelect(modelSelect, data);
                steps.model.classList.remove('hidden');
            });

            modelSelect.addEventListener('change', async () => {
                reset('variant');
                if (!modelSelect.value) return;
                const res = await fetch(`{{ route('finder.variants') }}?model=${modelSelect.value}`);
                const data = await res.json();
                fillSelect(variantSelect, data, (v) => {
                    const parts = [v.name];
                    if (v.fuel_type) parts.push(`(${v.fuel_type})`);
                    if (v.year_from) parts.push(v.year_to ? `${v.year_from}-${v.year_to}` : `${v.year_from}+`);
                    return parts.join(' ');
                });
                steps.variant.classList.remove('hidden');
            });

            variantSelect.addEventListener('change', () => {
                submit.disabled = !variantSelect.value;
            });
        });
        </script>
    @endpush
</x-layouts.app>
