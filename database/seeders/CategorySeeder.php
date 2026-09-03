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
                'name' => 'Madhubani Paintings',
                'slug' => 'madhubani-paintings',
                'description' => 'Authentic Mithila & Madhubani hand-painted artworks on handmade paper and canvas using natural pigments.',
            ],
            [
                'name' => 'Terracotta & Clay Dolls',
                'slug' => 'terracotta-clay-dolls',
                'description' => 'Earthy terracotta sculptures, decorative figurines, clay bride-groom sets, and traditional pottery.',
            ],
            [
                'name' => 'Jute & Sikki Grass Crafts',
                'slug' => 'jute-sikki-grass-crafts',
                'description' => 'Eco-friendly golden grass woven baskets, handwoven jute bags, mats, and festive décor.',
            ],
            [
                'name' => 'Sujini Embroidery Textiles',
                'slug' => 'sujini-embroidery-textiles',
                'description' => 'Heritage GI-tagged Sujini hand-embroidered story quilts, dupattas, and artisanal tapestries.',
            ],
            [
                'name' => 'Wooden & Bamboo Toys',
                'slug' => 'wooden-bamboo-toys',
                'description' => 'Eco-safe handcrafted wooden carts, whistling birds, bamboo puzzles, and vintage nursery toys.',
            ],
            [
                'name' => 'Home Décor & Brassware',
                'slug' => 'home-decor-brassware',
                'description' => 'Hand-engraved brass showpieces, ethnic hanging lamps, and artisanal accents for living spaces.',
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
