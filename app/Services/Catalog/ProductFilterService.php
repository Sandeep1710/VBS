<?php

namespace App\Services\Catalog;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilterService
{
    public const ALLOWED_SORTS = [
        'newest' => ['created_at', 'desc'],
        'price_asc' => ['price', 'asc'],
        'price_desc' => ['price', 'desc'],
        'rating' => ['rating_avg', 'desc'],
        'popular' => ['sales_count', 'desc'],
    ];

    public function paginate(Request $request, ?Category $category = null, ?BatteryBrand $brand = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::query()->active()->with(['batteryBrand', 'primaryImage', 'category']);

        if ($category) {
            $query->where('category_id', $category->id);
        }

        if ($brand) {
            $query->where('battery_brand_id', $brand->id);
        }

        $this->applyFilters($query, $request);
        $this->applySort($query, $request->input('sort'));

        return $query->paginate($perPage)->withQueryString();
    }

    public function applyFilters(Builder $query, Request $request): void
    {
        if ($q = trim((string) $request->input('q'))) {
            $query->where(function (Builder $b) use ($q) {
                $b->where('name', 'like', "%$q%")
                    ->orWhere('sku', 'like', "%$q%");
            });
        }

        if ($brands = $this->arrayParam($request, 'brand')) {
            $query->whereHas('batteryBrand', fn (Builder $b) => $b->whereIn('slug', $brands));
        }

        if ($categories = $this->arrayParam($request, 'category')) {
            $query->whereHas('category', fn (Builder $b) => $b->whereIn('slug', $categories));
        }

        if (($min = $request->input('min_price')) !== null && $min !== '') {
            $query->where('price', '>=', (float) $min);
        }

        if (($max = $request->input('max_price')) !== null && $max !== '') {
            $query->where('price', '<=', (float) $max);
        }

        if ($cMin = $request->input('capacity_min')) {
            $query->where('capacity_ah', '>=', (float) $cMin);
        }

        if ($cMax = $request->input('capacity_max')) {
            $query->where('capacity_ah', '<=', (float) $cMax);
        }

        if ($request->boolean('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        if ($request->boolean('exchange')) {
            $query->where('exchange_available', true);
        }

        if ($request->filled('warranty_min')) {
            $query->where('warranty_months', '>=', (int) $request->input('warranty_min'));
        }

        if ($variantId = $request->input('vehicle_variant')) {
            $query->whereHas('fitments', fn (Builder $b) => $b->where('vehicle_variant_id', (int) $variantId));
        }
    }

    public function applySort(Builder $query, ?string $sort): void
    {
        [$column, $direction] = self::ALLOWED_SORTS[$sort] ?? self::ALLOWED_SORTS['newest'];
        $query->orderBy($column, $direction);
        $query->orderBy('id', 'desc');
    }

    public function activeFilters(Request $request): array
    {
        return [
            'q' => trim((string) $request->input('q')),
            'brand' => $this->arrayParam($request, 'brand'),
            'category' => $this->arrayParam($request, 'category'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'in_stock' => $request->boolean('in_stock'),
            'exchange' => $request->boolean('exchange'),
            'sort' => array_key_exists($request->input('sort'), self::ALLOWED_SORTS)
                ? $request->input('sort')
                : null,
            'vehicle_variant' => $request->input('vehicle_variant'),
        ];
    }

    protected function arrayParam(Request $request, string $key): array
    {
        $value = $request->input($key);
        if (! $value) {
            return [];
        }
        return is_array($value) ? array_values(array_filter($value)) : array_filter(explode(',', (string) $value));
    }
}
