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
                'title' => 'Genuine Vehicle Batteries Online',
                'subtitle' => 'Free delivery and old battery exchange.',
                'image' => 'banners/hero-1.svg',
                'link_url' => '/products',
                'link_text' => 'Shop Now',
                'position' => 'home_hero',
                'sort_order' => 1,
            ],
            [
                'title' => 'Up to ₹800 Off on Old Battery Exchange',
                'subtitle' => 'Get instant value for your old battery.',
                'image' => 'banners/hero-2.svg',
                'link_url' => '/products?exchange=1',
                'link_text' => 'View Offers',
                'position' => 'home_hero',
                'sort_order' => 2,
            ],
        ];

        foreach ($banners as $b) {
            Banner::updateOrCreate(['title' => $b['title']], array_merge(['is_active' => true], $b));
        }
    }
}
