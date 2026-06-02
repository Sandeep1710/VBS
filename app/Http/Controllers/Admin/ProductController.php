<?php

namespace App\Http\Controllers\Admin;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends AdminController
{
    public function index(): View
    {
        $products = Product::with(['batteryBrand', 'category', 'primaryImage'])
            ->latest()
            ->get();
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $product = DB::transaction(function () use ($data, $request) {
            $data['slug'] = $this->uniqueSlug(Product::class, $data['name']);
            $data['sku'] = $data['sku'] ?: $this->generateSku();

            $imagePath = $this->storeImage($request->file('image'), 'products');
            unset($data['image']);

            $product = Product::create($data);

            if ($imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $imagePath,
                    'alt' => $product->name,
                    'sort_order' => 0,
                    'is_primary' => true,
                ]);
            }
            return $product;
        });

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        $product->load('primaryImage', 'images');
        return view('admin.products.edit', array_merge($this->formData(), ['product' => $product]));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product->id);

        DB::transaction(function () use ($data, $request, $product) {
            $data['slug'] = $product->name === $data['name']
                ? $product->slug
                : $this->uniqueSlug(Product::class, $data['name'], $product->id);
            $data['sku'] = $data['sku'] ?: ($product->sku ?: $this->generateSku());

            $imagePath = $request->hasFile('image')
                ? $this->storeImage($request->file('image'), 'products', $product->primaryImage?->path)
                : null;
            unset($data['image']);

            $product->update($data);

            if ($imagePath) {
                if ($existing = $product->primaryImage) {
                    $existing->update(['path' => $imagePath, 'alt' => $product->name]);
                } else {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $imagePath,
                        'alt' => $product->name,
                        'sort_order' => 0,
                        'is_primary' => true,
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product) {
            foreach ($product->images as $img) {
                $this->deleteImage($img->path);
                $img->delete();
            }
            $product->delete();
        });
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function formData(): array
    {
        return [
            'brands' => BatteryBrand::where('is_active', true)->orderBy('name')->get(),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request, ?int $productId = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:200'],
            'sku' => ['nullable', 'string', 'max:60', 'unique:products,sku,' . ($productId ?: 'NULL') . ',id'],
            'battery_brand_id' => ['required', 'integer', 'exists:battery_brands,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'capacity_ah' => ['nullable', 'numeric', 'min:0'],
            'voltage' => ['nullable', 'numeric', 'min:0'],
            'warranty_months' => ['nullable', 'integer', 'min:0', 'max:120'],
            'price' => ['required', 'numeric', 'min:0'],
            'offer_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'exchange_available' => ['nullable', 'boolean'],
            'exchange_discount' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        $data = $request->validate($rules);
        $data['exchange_available'] = $request->boolean('exchange_available');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['stock_quantity'] = (int) ($data['stock_quantity'] ?? 0);
        return $data;
    }

    private function generateSku(): string
    {
        do {
            $sku = 'PRD-' . strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());
        return $sku;
    }
}
