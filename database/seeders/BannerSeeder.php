<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Up to ₹800 Off on Old Battery Exchange',
                'subtitle' => 'Hand over your old battery at delivery and save instantly. No paperwork.',
                'image' => 'banners/hero-2.jpg',
                'link_url' => '/products?exchange=1',
                'link_text' => 'Claim Offer',
                'position' => 'home_hero',
                'sort_order' => 1,
            ],
            [
                'title' => 'Same-day Battery Delivery across Mumbai',
                'subtitle' => 'Free delivery + free installation + old battery exchange in all Mumbai pincodes.',
                'image' => 'banners/hero-1.svg',
                'link_url' => '/products',
                'link_text' => 'Shop Batteries',
                'position' => 'home_hero',
                'sort_order' => 2,
            ],
        ];

        // Delete any home_hero banners that aren't in the canonical list
        // (cleans up stale rows from earlier seeds — like "Genuine Vehicle Batteries Online")
        Banner::where('position', 'home_hero')
            ->whereNotIn('title', collect($banners)->pluck('title'))
            ->delete();

        foreach ($banners as $b) {
            Banner::updateOrCreate(['title' => $b['title']], array_merge(['is_active' => true], $b));
        }
    }
}
