<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics & Gadgets',
                'slug' => 'electronics-gadgets',
                'description' => 'Cutting-edge smartphones, laptops, smart audio, and accessories.',
            ],
            [
                'name' => 'Fashion & Apparel',
                'slug' => 'fashion-apparel',
                'description' => 'Premium casual wear, formal attire, footwear, and designer accessories.',
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Modern furniture, ambient lighting, and elegant home decor essentials.',
            ],
            [
                'name' => 'Fitness & Outdoor',
                'slug' => 'fitness-outdoor',
                'description' => 'High-performance athletic gear, workout equipment, and adventure wear.',
            ],
            [
                'name' => 'Books & Stationery',
                'slug' => 'books-stationery',
                'description' => 'Best-selling novels, productivity journals, and executive stationery.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'description' => $cat['description']]
            );
        }
    }
}

