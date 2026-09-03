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
        $madhubani = Category::where('slug', 'madhubani-paintings')->first();
        $terracotta = Category::where('slug', 'terracotta-clay-dolls')->first();
        $sikki = Category::where('slug', 'jute-sikki-grass-crafts')->first();
        $sujini = Category::where('slug', 'sujini-embroidery-textiles')->first();
        $wooden = Category::where('slug', 'wooden-bamboo-toys')->first();
        $brass = Category::where('slug', 'home-decor-brassware')->first();

        $products = [
            [
                'category_id' => $madhubani?->id,
                'name' => 'Traditional Tree of Life Madhubani Painting',
                'slug' => 'traditional-tree-of-life-painting',
                'description' => 'Exquisitely hand-painted Mithila artwork illustrating the eternal Tree of Life adorned with peacocks, sacred birds, and auspicious floral motifs using natural dye pigments on handmade paper.',
                'price' => 1899.00,
                'image' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $madhubani?->id,
                'name' => 'Kohbar Marriage Blessing Folk Artwork',
                'slug' => 'kohbar-marriage-blessing-artwork',
                'description' => 'Ceremonial bridal Kohbar masterpiece capturing symbols of prosperity, fertility, and marital harmony crafted with fine bamboo nibs and mineral colors.',
                'price' => 2450.00,
                'image' => 'https://images.unsplash.com/photo-1582561073867-0c17a5ef694c?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $madhubani?->id,
                'name' => 'Radha Krishna Divine Love Painting',
                'slug' => 'radha-krishna-divine-love-painting',
                'description' => 'Intricately bordered devotional composition portraying Radha and Krishna amidst Kadamba trees in the classical Kachni & Bharni double-line Mithila style.',
                'price' => 3100.00,
                'image' => 'https://images.unsplash.com/photo-1577083552431-6e5fd01aa342?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $terracotta?->id,
                'name' => 'Handcrafted Terracotta Horse Sculpture',
                'slug' => 'handcrafted-terracotta-horse',
                'description' => 'Kiln-fired earthenware folk horse featuring hand-etched saddle bells, tribal medallions, and natural burnished clay texture created by master potters of Bihar.',
                'price' => 1250.00,
                'image' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $terracotta?->id,
                'name' => 'Traditional Clay Bride and Groom Dolls',
                'slug' => 'traditional-clay-bride-groom-dolls',
                'description' => 'Pair of ceremonial handcrafted clay figurines attired in traditional festive attire, hand-painted with organic vegetable colors for wedding décor and cultural gifting.',
                'price' => 980.00,
                'image' => 'https://images.unsplash.com/photo-1569388330292-79cc1ec67270?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $terracotta?->id,
                'name' => 'Terracotta Ganesha Wall Hanging Plaque',
                'slug' => 'terracotta-ganesha-wall-hanging',
                'description' => 'Auspicious Lord Ganesha terracotta relief wall art relief with detailed modak, crown, and rustic sunburst backdrop for doorways and pooja rooms.',
                'price' => 750.00,
                'image' => 'https://images.unsplash.com/photo-1606744888344-4982389d1467?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $sikki?->id,
                'name' => 'Sikki Grass Handwoven Storage Basket',
                'slug' => 'sikki-grass-handwoven-basket',
                'description' => 'Durable and fragrant golden Sikki grass hand-braided basket featuring natural indigo-dyed geometric motifs and snug fitted lid.',
                'price' => 640.00,
                'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94801759?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $sujini?->id,
                'name' => 'Traditional Sujini Storytelling Quilt',
                'slug' => 'traditional-sujini-storytelling-quilt',
                'description' => 'Authentic GI-protected Sujini embroidered layered cotton throw depicting village folklore, nature flora, and rural celebrations with fine running stitch embroidery.',
                'price' => 2800.00,
                'image' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $wooden?->id,
                'name' => 'Hand-Painted Wooden Bird Whistle & Figurine',
                'slug' => 'hand-painted-wooden-bird-toy',
                'description' => 'Carved from soft locally sourced wood and finished with non-toxic lac colors. Safe for children and delightful as desktop folk art.',
                'price' => 450.00,
                'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $wooden?->id,
                'name' => 'Traditional Wooden Toy Cart with Rolling Wheels',
                'slug' => 'traditional-wooden-toy-cart',
                'description' => 'Vintage style wooden bullock cart toy crafted by local carpenters using reclaimed teak with smooth edges and natural beeswax polish.',
                'price' => 690.00,
                'image' => 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'category_id' => $brass?->id,
                'name' => 'Polished Brass Elephant Royal Showpiece',
                'slug' => 'polished-brass-elephant-showpiece',
                'description' => 'Solid brass elephant statue decorated with ceremonial royal howdah engravings and antique golden patina finish.',
                'price' => 1650.00,
                'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=800&auto=format&fit=crop&q=80',
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
