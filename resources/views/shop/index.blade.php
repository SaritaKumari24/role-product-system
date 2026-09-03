@extends('layouts.app')

@section('title', 'Product Catalog')

@section('content')
<div class="space-y-12">
    <!-- Hero Banner -->
    <section class="relative overflow-hidden pt-12 pb-16 px-4 sm:px-6 lg:px-8 border-b border-white/5 bg-gradient-to-b from-slate-900/60 via-slate-950 to-slate-950">
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <!-- Pill badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-brand-500/10 text-brand-300 border border-brand-500/30 mb-6">
                <i class="fa-solid fa-sparkles text-amber-400"></i>
                <span>Role-Based Access Control + Cropper.js Powered Catalog</span>
            </div>

            <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight max-w-3xl mx-auto leading-tight">
                Discover Premium <span class="bg-gradient-to-r from-brand-400 via-indigo-300 to-indigo-500 bg-clip-text text-transparent">Curated Products</span>
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto mt-4">
                Explore our catalog created and organized by Managers and Admins with live image cropping and Spatie permissions.
            </p>

            <!-- Search Bar in Hero -->
            <div class="max-w-2xl mx-auto mt-8">
                <form action="{{ route('shop.index') }}" method="GET" class="relative flex items-center shadow-2xl">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products by title, keyword, or specs..."
                           class="w-full pl-11 pr-28 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition">
                    
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <button type="submit" class="absolute right-2 px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold transition">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-brand-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </section>

    <!-- Main Catalog Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Filter Controls Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-4 border-b border-slate-800">
            <!-- Category Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ !request('category') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}">
                    All Categories
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}" 
                       class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ request('category') === $category->slug ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}">
                        <span>{{ $category->name }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ request('category') === $category->slug ? 'bg-black/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                            {{ $category->products_count }}
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- Sort By Dropdown -->
            <div class="flex items-center gap-3 self-end md:self-auto">
                <span class="text-xs font-semibold text-slate-400">Sort by:</span>
                <form action="{{ route('shop.index') }}" method="GET" id="sortForm">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-medium focus:border-brand-500 outline-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Product Name (A-Z)</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Active Filter Indicator -->
        @if(request()->hasAny(['search', 'category']))
            <div class="flex items-center gap-2 text-xs text-slate-400">
                <span>Active filters:</span>
                @if(request('search'))
                    <span class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 text-white flex items-center gap-1.5">
                        Keyword: "{{ request('search') }}"
                        <a href="{{ route('shop.index', request()->except('search')) }}" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></a>
                    </span>
                @endif
                @if($selectedCategory)
                    <span class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 text-brand-300 flex items-center gap-1.5">
                        Category: {{ $selectedCategory->name }}
                        <a href="{{ route('shop.index', request()->except('category')) }}" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></a>
                    </span>
                @endif
                <a href="{{ route('shop.index') }}" class="text-rose-400 hover:text-rose-300 ml-2 font-medium">Clear all</a>
            </div>
        @endif

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="glass-card rounded-3xl overflow-hidden group hover:border-brand-500/40 hover:shadow-2xl hover:shadow-brand-500/10 transition duration-300 flex flex-col justify-between">
                    <div>
                        <!-- Product Image Area -->
                        <div class="relative aspect-square overflow-hidden bg-slate-900">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            
                            <!-- Category Badge on Image -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold bg-slate-950/80 backdrop-blur-md text-brand-300 border border-white/10 shadow-sm">
                                    {{ $product->category?->name ?? 'General' }}
                                </span>
                            </div>

                            <!-- View Overlay Quick Icon -->
                            <a href="{{ route('shop.show', $product->slug) }}" class="absolute inset-0 bg-brand-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="px-4 py-2 rounded-xl bg-white text-slate-950 text-xs font-bold shadow-xl transform translate-y-2 group-hover:translate-y-0 transition duration-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-eye"></i> Quick View
                                </span>
                            </a>
                        </div>

                        <!-- Product Content Details -->
                        <div class="p-5">
                            <h3 class="font-bold text-white text-base group-hover:text-brand-300 transition line-clamp-1">
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-400 mt-1.5 line-clamp-2 leading-relaxed">
                                {{ $product->description ?? 'No description provided.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer (Price & Action) -->
                    <div class="px-5 pb-5 pt-2 border-t border-slate-800/60 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Price</span>
                            <span class="text-lg font-extrabold text-white">${{ number_format($product->price, 2) }}</span>
                        </div>

                        <a href="{{ route('shop.show', $product->slug) }}" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-brand-600 text-slate-300 hover:text-white text-xs font-semibold border border-slate-700 hover:border-brand-500 transition flex items-center gap-1.5">
                            <span>Details</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-slate-900 border border-slate-800 flex items-center justify-center mx-auto mb-4 text-slate-600 text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">No products found</h3>
                    <p class="text-xs text-slate-400 mt-1">Try changing your search terms or filter selections.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block mt-4 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-semibold">
                        View All Products
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
    </div>
</div>
@endsection
