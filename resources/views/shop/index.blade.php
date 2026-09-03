@extends('layouts.app')

@section('title', 'Handcraft & Art Marketplace in Katihar, Bihar')

@section('content')
<div class="space-y-16">
    <!-- Hero Banner Section (LittlePicassos Inspired) -->
    <section class="relative bg-gradient-to-b from-[#F7F2E7] via-[#FCFBF7] to-[#FCFBF7] pt-10 pb-16 px-4 sm:px-6 lg:px-8 border-b border-[#EAE5D9]">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Hero Left Column -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#EFE7D8] text-terracotta-700 border border-[#DFCFA8]">
                        <i class="fa-solid fa-gem text-amber-600"></i>
                        <span>Heritage Handicrafts &bull; Direct from Master Artisans</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#2B231D] tracking-tight font-serif leading-[1.15]">
                        Discover Authentic <span class="text-terracotta-500 italic">Handcrafted Art</span> & Décor
                    </h1>

                    <p class="text-sm sm:text-base text-[#675B50] max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Explore timeless Madhubani folk paintings, kiln-fired terracotta figurines, golden Sikki grass crafts, and authentic regional treasures made in Katihar, Bihar.
                    </p>

                    <!-- Search Bar in Hero -->
                    <div class="max-w-xl mx-auto lg:mx-0 pt-2">
                        <form action="{{ route('shop.index') }}" method="GET" class="relative flex items-center shadow-lg rounded-2xl overflow-hidden bg-white border border-[#E0D8C8]">
                            <span class="pl-4 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search handcrafted paintings, clay dolls, baskets..."
                                   class="w-full pl-3 pr-28 py-4 bg-transparent text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none">
                            
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            <button type="submit" class="absolute right-2 px-5 py-2.5 rounded-xl bg-terracotta-500 hover:bg-terracotta-600 text-white text-xs font-bold transition shadow-sm">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Trust Stats -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 pt-2 text-xs text-[#675B50]">
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-certificate text-terracotta-500"></i> 100% Genuine Artisan</span>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-amber-600"></i> Worldwide Delivery</span>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield-heart text-emerald-600"></i> Ethical Fair Trade</span>
                    </div>
                </div>

                <!-- Hero Right Column: Promotional Mini-Cards -->
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                    <div class="p-6 rounded-3xl bg-gradient-to-br from-[#FAF5EC] to-[#F1E8D7] border border-[#E6DBCA] shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-terracotta-600 block">Heritage Textiles</span>
                            <h3 class="text-base font-bold text-[#2B231D] font-serif mt-1">Sujini Embroidery Quilt</h3>
                            <a href="{{ route('shop.index', ['category' => 'sujini-embroidery-textiles']) }}" class="inline-flex items-center gap-1 text-xs font-bold text-terracotta-600 hover:text-terracotta-700 mt-2">
                                <span>Shop Now</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-white/80 border border-[#E0D4C0] flex items-center justify-center text-2xl text-terracotta-500">
                            <i class="fa-solid fa-rug"></i>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-gradient-to-br from-[#FDF6F0] to-[#F5E6DC] border border-[#EBD4C6] shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 block">Unique Gift Ideas</span>
                            <h3 class="text-base font-bold text-[#2B231D] font-serif mt-1">Terracotta & Clay Dolls</h3>
                            <a href="{{ route('shop.index', ['category' => 'terracotta-clay-dolls']) }}" class="inline-flex items-center gap-1 text-xs font-bold text-terracotta-600 hover:text-terracotta-700 mt-2">
                                <span>Shop Now</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-white/80 border border-[#E0D4C0] flex items-center justify-center text-2xl text-amber-600">
                            <i class="fa-solid fa-masks-theater"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Browse Popular Categories Showcase -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-terracotta-600">Explore Departments</span>
                <h2 class="text-2xl sm:text-3xl font-black text-[#2B231D] font-serif tracking-tight mt-0.5">Browse Popular Categories</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-terracotta-600 hover:text-terracotta-700 flex items-center gap-1.5">
                <span>View All</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" 
                   class="artisan-card rounded-2xl p-4 text-center group transition duration-300 hover:-translate-y-1 flex flex-col justify-between items-center {{ request('category') === $cat->slug ? 'border-terracotta-500 ring-2 ring-terracotta-500/20 bg-[#FDFBF7]' : '' }}">
                    <div class="w-14 h-14 rounded-2xl bg-[#F8F4EC] group-hover:bg-terracotta-50 border border-[#EAE5D9] group-hover:border-terracotta-200 flex items-center justify-center text-xl text-terracotta-600 mb-3 transition">
                        @if(str_contains($cat->slug, 'madhubani'))
                            <i class="fa-solid fa-palette"></i>
                        @elseif(str_contains($cat->slug, 'terracotta'))
                            <i class="fa-solid fa-monument"></i>
                        @elseif(str_contains($cat->slug, 'sikki') || str_contains($cat->slug, 'jute'))
                            <i class="fa-solid fa-basket-shopping"></i>
                        @elseif(str_contains($cat->slug, 'sujini') || str_contains($cat->slug, 'textile'))
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        @elseif(str_contains($cat->slug, 'wood') || str_contains($cat->slug, 'toy'))
                            <i class="fa-solid fa-puzzle-piece"></i>
                        @else
                            <i class="fa-solid fa-gem"></i>
                        @endif
                    </div>
                    <h3 class="text-xs font-bold text-[#2B231D] group-hover:text-terracotta-600 transition line-clamp-2">
                        {{ $cat->name }}
                    </h3>
                    <span class="mt-2 text-[10px] font-semibold text-[#8A7F73] px-2 py-0.5 rounded-full bg-[#F4EFE6]">
                        {{ $cat->products_count }} items
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Main Handcrafted Catalog Showcase -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Filter Controls Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-4 border-b border-[#EAE5D9]">
            <!-- Category Filter Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('category') ? 'bg-terracotta-500 text-white shadow-md shadow-terracotta-500/20' : 'bg-white text-slate-700 hover:bg-[#F8F4EC] border border-[#EAE5D9]' }}">
                    All Collections
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}" 
                       class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request('category') === $category->slug ? 'bg-terracotta-500 text-white shadow-md shadow-terracotta-500/20' : 'bg-white text-slate-700 hover:bg-[#F8F4EC] border border-[#EAE5D9]' }}">
                        <span>{{ $category->name }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ request('category') === $category->slug ? 'bg-black/20 text-white' : 'bg-[#F2ECE0] text-slate-600' }}">
                            {{ $category->products_count }}
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- Sort By Dropdown -->
            <div class="flex items-center gap-2 self-end md:self-auto">
                <span class="text-xs font-bold text-[#675B50]">Sort by:</span>
                <form action="{{ route('shop.index') }}" method="GET" id="sortForm">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="px-3 py-2 rounded-xl bg-white border border-[#DCCFBA] text-slate-800 text-xs font-semibold focus:border-terracotta-500 outline-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Masterworks</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Product Title (A-Z)</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Active Filter Indicator -->
        @if(request()->hasAny(['search', 'category']))
            <div class="flex items-center gap-2 text-xs text-[#675B50]">
                <span class="font-semibold">Active filters:</span>
                @if(request('search'))
                    <span class="px-3 py-1 rounded-lg bg-white border border-[#E0D8C8] text-slate-800 flex items-center gap-1.5 font-medium shadow-sm">
                        Keyword: "{{ request('search') }}"
                        <a href="{{ route('shop.index', request()->except('search')) }}" class="text-slate-400 hover:text-rose-600 ml-1"><i class="fa-solid fa-xmark"></i></a>
                    </span>
                @endif
                @if($selectedCategory)
                    <span class="px-3 py-1 rounded-lg bg-terracotta-50 border border-terracotta-200 text-terracotta-800 flex items-center gap-1.5 font-semibold shadow-sm">
                        Category: {{ $selectedCategory->name }}
                        <a href="{{ route('shop.index', request()->except('category')) }}" class="text-terracotta-400 hover:text-rose-600 ml-1"><i class="fa-solid fa-xmark"></i></a>
                    </span>
                @endif
                <a href="{{ route('shop.index') }}" class="text-rose-600 hover:text-rose-700 ml-2 font-bold">Clear all</a>
            </div>
        @endif

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="artisan-card rounded-3xl overflow-hidden group transition duration-300 flex flex-col justify-between">
                    <div>
                        <!-- Product Image Box -->
                        <div class="relative aspect-square overflow-hidden bg-[#F5F0E6]">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-xl text-[11px] font-bold bg-white/95 text-[#7C5731] border border-[#EAE5D9] shadow-sm">
                                    {{ $product->category?->name ?? 'Artisan Craft' }}
                                </span>
                            </div>

                            <!-- Quick Action Overlay -->
                            <a href="{{ route('shop.show', $product->slug) }}" class="absolute inset-0 bg-[#2B231D]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="px-4 py-2 rounded-xl bg-white text-[#2B231D] text-xs font-bold shadow-xl transform translate-y-2 group-hover:translate-y-0 transition duration-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-eye"></i> View Artwork
                                </span>
                            </a>
                        </div>

                        <!-- Product Content Info -->
                        <div class="p-5">
                            <!-- Star Rating -->
                            <div class="flex items-center gap-1 text-amber-500 text-xs mb-1.5">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span class="text-[11px] font-semibold text-[#8A7F73] ml-1">(5.0)</span>
                            </div>

                            <h3 class="font-bold text-[#2B231D] text-base group-hover:text-terracotta-600 transition font-serif line-clamp-1">
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-[#675B50] mt-1.5 line-clamp-2 leading-relaxed">
                                {{ $product->description ?? 'Authentic artisan handmade creation.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer: Price & Add to Cart -->
                    <div class="px-5 pb-5 pt-3 border-t border-[#F2ECE0] flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-[#8A7F73] uppercase tracking-wider block">Price</span>
                            <span class="text-lg font-black text-[#2B231D]">₹{{ number_format($product->price, 2) }}</span>
                        </div>

                        <a href="{{ route('shop.show', $product->slug) }}" class="px-4 py-2 rounded-xl bg-[#F8F4EC] hover:bg-terracotta-500 text-[#4A3B32] hover:text-white text-xs font-bold border border-[#E0D8C8] hover:border-terracotta-500 transition flex items-center gap-1.5">
                            <span>Details</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center artisan-card rounded-3xl p-10">
                    <div class="w-16 h-16 rounded-3xl bg-[#F8F4EC] border border-[#E0D8C8] flex items-center justify-center mx-auto mb-4 text-[#A89D91] text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#2B231D] font-serif">No products found</h3>
                    <p class="text-xs text-[#675B50] mt-1">Try adjusting your search keywords or browsing different categories.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block mt-4 px-5 py-2.5 rounded-xl bg-terracotta-500 text-white text-xs font-bold">
                        Browse All Collections
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="pt-6">
                {{ $products->links() }}
            </div>
        @endif
    </section>

    <!-- "Our Happy Customers" Testimonials (LittlePicassos) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-terracotta-600">Loved by Art Patrons</span>
            <h2 class="text-2xl sm:text-3xl font-black text-[#2B231D] font-serif tracking-tight mt-0.5">Our Happy Customers</h2>
            <p class="text-xs text-[#675B50] mt-1">Authentic reviews from collectors and home decorators across the globe.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="artisan-card rounded-3xl p-6 space-y-4">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-[#4A3B32] italic leading-relaxed">
                    "The Sikki grass basket is a masterpiece! Exquisite weaving, lightweight yet so strong. It adds such an earthy elegance to our living room."
                </p>
                <div class="pt-3 border-t border-[#F2ECE0]">
                    <p class="text-xs font-bold text-[#2B231D]">Aditi Sharma</p>
                    <p class="text-[10px] text-terracotta-600 font-semibold">Verified Buyer &bull; New Delhi</p>
                </div>
            </div>

            <div class="artisan-card rounded-3xl p-6 space-y-4">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-[#4A3B32] italic leading-relaxed">
                    "Purchased the Sujini storytelling quilt for our anniversary. The detailed needlework narrating rural folklore is simply heartwarming."
                </p>
                <div class="pt-3 border-t border-[#F2ECE0]">
                    <p class="text-xs font-bold text-[#2B231D]">Vikram Goel</p>
                    <p class="text-[10px] text-terracotta-600 font-semibold">Verified Buyer &bull; Bengaluru</p>
                </div>
            </div>

            <div class="artisan-card rounded-3xl p-6 space-y-4">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-[#4A3B32] italic leading-relaxed">
                    "The Tree of Life painting was securely shipped all the way to London. Outstanding colors and true authenticity. Highly recommended!"
                </p>
                <div class="pt-3 border-t border-[#F2ECE0]">
                    <p class="text-xs font-bold text-[#2B231D]">Rebecca Johnson</p>
                    <p class="text-[10px] text-terracotta-600 font-semibold">Art Collector &bull; UK</p>
                </div>
            </div>

            <div class="artisan-card rounded-3xl p-6 space-y-4">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-[#4A3B32] italic leading-relaxed">
                    "The terracotta horse figurine has breathtaking detailing. Knowing it directly supports village potters in Bihar makes it even more special."
                </p>
                <div class="pt-3 border-t border-[#F2ECE0]">
                    <p class="text-xs font-bold text-[#2B231D]">Mark Adouzie</p>
                    <p class="text-[10px] text-terracotta-600 font-semibold">Verified Buyer &bull; Mumbai</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Artisan Community Call to Action Banner (LittlePicassos) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-[#3D2C22] via-[#2B231D] to-[#453124] text-white p-8 sm:p-12 shadow-xl border border-[#5A4537] flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="space-y-3 max-w-xl text-center md:text-left">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    Artisan Empowerment
                </span>
                <h3 class="text-2xl sm:text-3xl font-black font-serif tracking-tight">
                    Millions of shoppers can't wait to discover what you have in store.
                </h3>
                <p class="text-xs text-[#C9BFB5] leading-relaxed">
                    Every purchase preserves indigenous folk traditions, provides sustainable livelihood to rural artisans, and brings authentic cultural heritage to homes.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                <a href="{{ route('shop.index') }}" class="px-6 py-3.5 rounded-2xl bg-terracotta-500 hover:bg-terracotta-600 text-white text-xs font-bold shadow-lg shadow-terracotta-500/30 transition text-center">
                    Explore Collections
                </a>
                <a href="https://api.whatsapp.com/send/?phone=919570479650" target="_blank" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 transition flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                    <span>Artisan Inquiry</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
