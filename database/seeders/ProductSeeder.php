<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $electronics = Category::where('slug', 'electronics-gadgets')->first();
        $fashion = Category::where('slug', 'fashion-apparel')->first();
        $home = Category::where('slug', 'home-living')->first();
        $fitness = Category::where('slug', 'fitness-outdoor')->first();
        $books = Category::where('slug', 'books-stationery')->first();

        $products = [
            [
                'category_id' => $electronics?->id,
                'name' => 'Pro Sound Active Noise Cancelling Headphones',
                'slug' => 'pro-sound-anc-headphones',
                'description' => 'Engineered with studio-grade 40mm drivers, adaptive active noise cancellation, and up to 45 hours of immersive audio playback on a single fast charge.',
                'price' => 249.99,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $electronics?->id,
                'name' => 'Ultra-Slim OLED Smartwatch 2',
                'slug' => 'ultra-slim-oled-smartwatch-2',
                'description' => 'Featuring all-day ECG & SpO2 biometric tracking, vivid sapphire glass AMOLED display, titanium chassis, and water resistance up to 50 meters.',
                'price' => 199.50,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $fashion?->id,
                'name' => 'Minimalist Everyday Leather Backpack',
                'slug' => 'minimalist-everyday-leather-backpack',
                'description' => 'Handcrafted from full-grain Italian leather with dedicated 16-inch padded laptop sleeve, waterproof brass zippers, and ergonomic shoulder straps.',
                'price' => 139.00,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $fashion?->id,
                'name' => 'Classic Heritage Polarized Sunglasses',
                'slug' => 'classic-heritage-polarized-sunglasses',
                'description' => 'Timeless acetate frames equipped with UV400 anti-glare polarized lenses offering crystal-clear optics and lightweight comfort.',
                'price' => 89.90,
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $home?->id,
                'name' => 'Architectural Modern Ceramic Desk Lamp',
                'slug' => 'architectural-modern-ceramic-desk-lamp',
                'description' => 'Warm dimmable LED ambiance light with a matte sand-textured ceramic base and spun-brass touch control dimmer switch.',
                'price' => 115.00,
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $fitness?->id,
                'name' => 'Ultra-Grip Eco-Friendly Natural Rubber Yoga Mat',
                'slug' => 'ultra-grip-eco-yoga-mat',
                'description' => 'Non-slip polyurethane surface with alignment markers and 5mm high-density natural tree rubber cushioning for joints.',
                'price' => 68.00,
                'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $books?->id,
                'name' => 'Artisan Leather Journal & Calligraphy Pen Set',
                'slug' => 'artisan-leather-journal-pen-set',
                'description' => '240 pages of 120gsm bleed-proof cotton paper encased in rustic distressed leather with a weighted fountain pen.',
                'price' => 45.00,
                'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=700&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
        ];

        foreach ($products as $prod) {
            if ($prod['category_id']) {
                Product::firstOrCreate(
                    ['slug' => $prod['slug']],
                    $prod
                );
            }
        }
    }
}

