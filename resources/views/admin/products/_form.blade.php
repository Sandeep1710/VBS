@php($product = $product ?? null)

<x-card title="Basics">
    <div class="grid gap-4 md:grid-cols-2">
        <div class="md:col-span-2">
            <x-label for="name" value="Product name" required />
            <x-input name="name" :value="optional($product)->name" required />
            <x-input-error for="name" />
        </div>

        <div>
            <x-label for="battery_brand_id" value="Brand" required />
            <select name="battery_brand_id" id="battery_brand_id" class="input" required>
                <option value="">Select brand</option>
                @foreach($brands as $b)
                    <option value="{{ $b->id }}" @selected(old('battery_brand_id', optional($product)->battery_brand_id) == $b->id)>{{ $b->name }}</option>
                @endforeach
            </select>
            <x-input-error for="battery_brand_id" />
        </div>

        <div>
            <x-label for="category_id" value="Category" />
            <select name="category_id" id="category_id" class="input">
                <option value="">— None —</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', optional($product)->category_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <x-label for="sku" value="SKU (auto-generated if blank)" />
            <x-input name="sku" :value="optional($product)->sku" placeholder="PRD-XXXXXXXX" />
            <x-input-error for="sku" />
        </div>

        <div></div>
    </div>
</x-card>

<x-card title="Pricing & Stock">
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <x-label for="price" value="MRP (₹)" required />
            <x-input name="price" type="number" step="0.01" min="0" :value="optional($product)->price" required />
            <x-input-error for="price" />
        </div>

        <div>
            <x-label for="offer_price" value="Offer price (₹)" />
            <x-input name="offer_price" type="number" step="0.01" min="0" :value="optional($product)->offer_price" />
            <x-input-error for="offer_price" />
        </div>

        <div>
            <x-label for="stock_quantity" value="Stock quantity" />
            <x-input name="stock_quantity" type="number" min="0" :value="optional($product)->stock_quantity ?? 0" />
        </div>
    </div>
</x-card>

<x-card title="Specifications">
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <x-label for="capacity_ah" value="Capacity (Ah)" />
            <x-input name="capacity_ah" type="number" step="0.01" min="0" :value="optional($product)->capacity_ah" />
        </div>

        <div>
            <x-label for="voltage" value="Voltage (V)" />
            <x-input name="voltage" type="number" step="0.01" min="0" :value="optional($product)->voltage" />
        </div>

        <div>
            <x-label for="warranty_months" value="Warranty (months)" />
            <x-input name="warranty_months" type="number" min="0" max="120" :value="optional($product)->warranty_months" />
        </div>
    </div>
</x-card>

<x-card title="Description & Image">
    <div class="grid gap-4">
        <div>
            <x-label for="short_description" value="Short description" />
            <textarea name="short_description" id="short_description" rows="2" maxlength="500" class="input">{{ old('short_description', optional($product)->short_description) }}</textarea>
        </div>

        <div>
            <x-label for="description" value="Long description" />
            <textarea name="description" id="description" rows="10" class="input">{{ old('description', optional($product)->description) }}</textarea>
        </div>

        <div>
            <x-label for="image" value="Primary image" />
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                   class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200">
            <x-input-error for="image" />
            @if(optional($product?->primaryImage)->path)
                <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="" class="mt-2 h-24 w-24 rounded-lg object-cover ring-1 ring-ink-200">
            @endif
        </div>
    </div>
</x-card>

<x-card title="Exchange & Display">
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <x-label for="exchange_discount" value="Exchange discount (₹)" />
            <x-input name="exchange_discount" type="number" step="0.01" min="0" :value="optional($product)->exchange_discount ?? 0" />
        </div>

        <div class="md:col-span-2">
            <x-label value="Options" />
            <div class="mt-2 flex flex-wrap gap-6 text-sm text-ink-700">
                <label class="flex cursor-pointer items-center gap-2">
                    <input type="checkbox" name="exchange_available" value="1" @checked(old('exchange_available', optional($product)->exchange_available)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                    Old battery exchange available
                </label>
                <label class="flex cursor-pointer items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', optional($product)->is_featured)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                    Featured on homepage
                </label>
                <label class="flex cursor-pointer items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                    Active (visible on store)
                </label>
            </div>
        </div>
    </div>
</x-card>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ClassicEditor.create(document.querySelector('#description'), {
        toolbar: [
            'heading',
            '|',
            'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript',
            'link', 'blockQuote', 'codeBlock',
            'bulletedList', 'numberedList', 'todoList',
            '|',
            'alignment', 'outdent', 'indent',
            '|',
            'fontColor', 'fontBackgroundColor', 'fontSize', 'fontFamily',
            '|',
            'insertTable', 'imageUpload', 'mediaEmbed', 'horizontalLine', 'pageBreak',
            '|',
            'undo', 'redo', 'removeFormat', 'highlight', 'specialCharacters'
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        fontFamily: {
            options: [
                'default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
            ]
        },
        fontSize: { options: [ 'tiny', 'small', 'default', 'big', 'huge' ] },
        alignment: { options: [ 'left', 'center', 'right', 'justify' ] }
    })
    .catch(function (error) { console.error(error); });
});
</script>
