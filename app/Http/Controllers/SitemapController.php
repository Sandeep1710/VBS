<?php

namespace App\Http\Controllers;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $items = [];

        $items[] = ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'];
        $items[] = ['loc' => url('/products'), 'priority' => '0.9', 'changefreq' => 'daily'];
        $items[] = ['loc' => url('/finder'), 'priority' => '0.8', 'changefreq' => 'monthly'];

        foreach (Product::active()->select('slug', 'updated_at')->get() as $product) {
            $items[] = [
                'loc' => route('products.show', $product),
                'lastmod' => $product->updated_at?->toAtomString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        }

        foreach (Category::where('is_active', true)->select('slug', 'updated_at')->get() as $cat) {
            $items[] = [
                'loc' => route('categories.show', $cat),
                'lastmod' => $cat->updated_at?->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }

        foreach (BatteryBrand::where('is_active', true)->select('slug', 'updated_at')->get() as $brand) {
            $items[] = [
                'loc' => route('brands.show', $brand),
                'lastmod' => $brand->updated_at?->toAtomString(),
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ];
        }

        foreach (CmsPage::where('is_active', true)->select('slug', 'updated_at')->get() as $page) {
            $items[] = [
                'loc' => url('/cms/' . $page->slug),
                'lastmod' => $page->updated_at?->toAtomString(),
                'priority' => '0.5',
                'changefreq' => 'monthly',
            ];
        }

        $prolog = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' . "\n";
        $body = view('sitemap', ['items' => $items])->render();

        return response($prolog . $body, 200)->header('Content-Type', 'application/xml; charset=utf-8');
    }

    public function robots(): Response
    {
        $base = rtrim(config('app.url'), '/');
        $content = <<<TXT
User-agent: *
Allow: /
Disallow: /admin
Disallow: /account
Disallow: /checkout
Disallow: /cart

Sitemap: {$base}/sitemap.xml
TXT;

        return response($content, 200)->header('Content-Type', 'text/plain; charset=utf-8');
    }
}
