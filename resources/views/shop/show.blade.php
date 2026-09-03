@extends('layouts.app')

@section('title', $product->name . ' - Handcrafted Art')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    <!-- Breadcrumbs & Quick Nav -->
    <div class="flex items-center justify-between">
        <nav class="flex items-center gap-2 text-xs text-[#8A7F73]">
            <a href="{{ route('home') }}" class="hover:text-terracotta-600 transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[9px] text-[#C9BFB5]"></i>
            <a href="{{ route('shop.index', ['category' => $product->category?->slug]) }}" class="hover:text-terracotta-600 transition">
                {{ $product->category?->name ?? 'Artisan Catalog' }}
            </a>
            <i class="fa-solid fa-chevron-right text-[9px] text-[#C9BFB5]"></i>
            <span class="text-[#2B231D] font-semibold truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>

        @auth
            @if(auth()->user()->hasRole(['admin', 'manager']) || auth()->user()->can('edit-products'))
                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-terracotta-50 text-terracotta-700 border border-terracotta-200 text-xs font-bold hover:bg-terracotta-500 hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit in Admin Panel</span>
                </a>
            @endif
        @endauth
    </div>

    <!-- Product Showcase Card -->
    <div class="artisan-card rounded-3xl p-6 sm:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Left: Product Image Showcase -->
            <div class="lg:col-span-6 space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-[#F8F4EC] border border-[#EAE5D9] shadow-md">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-xl text-xs font-bold bg-white/95 backdrop-blur-md text-[#7C5731] border border-[#EAE5D9] shadow-sm">
                            <i class="fa-solid fa-palette mr-1 text-terracotta-500"></i> {{ $product->category?->name ?? 'Authentic Craft' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Information & Attributes -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Star Ratings & Review count -->
                    <div class="flex items-center gap-2 text-amber-500 text-xs mb-2">
                        <div class="flex items-center">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-xs font-bold text-[#2B231D]">5.0</span>
                        <span class="text-[#8A7F73]">(Artisan Verified Masterwork)</span>
                    </div>

                    <!-- Product Title -->
                    <h1 class="text-2xl sm:text-3xl font-black text-[#2B231D] tracking-tight font-serif leading-snug">
                        {{ $product->name }}
                    </h1>

                    <!-- Price & Stock Status -->
                    <div class="flex items-center gap-6 mt-4 pb-6 border-b border-[#F2ECE0]">
                        <div>
                            <span class="text-[10px] font-bold text-[#8A7F73] uppercase tracking-wider block">Artisan Price</span>
                            <span class="text-3xl font-black text-[#2B231D]">₹{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="pl-6 border-l border-[#F2ECE0]">
                            <span class="text-[10px] font-bold text-[#8A7F73] uppercase tracking-wider block">Availability</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 mt-1">
                                <i class="fa-solid fa-circle-check"></i> In Stock & Ready to Dispatch
                            </span>
                        </div>
                    </div>

                    <!-- Description Body -->
                    <div class="mt-6 space-y-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#675B50]">Artisan Creation & Heritage Details</h3>
                        <p class="text-[#4A3B32] text-sm leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'Authentic handcrafted piece crafted with natural elements and traditional regional motifs.' }}
                        </p>
                    </div>

                    <!-- Highlight Features -->
                    <div class="mt-8 grid grid-cols-2 gap-3">
                        <div class="p-4 rounded-2xl bg-[#F8F4EC] border border-[#EAE5D9]">
                            <i class="fa-solid fa-truck-fast text-terracotta-500 mb-1.5 text-base block"></i>
                            <p class="text-xs font-bold text-[#2B231D]">Fast Safe Delivery</p>
                            <p class="text-[11px] text-[#675B50]">Dispatched in protective packaging</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-[#F8F4EC] border border-[#EAE5D9]">
                            <i class="fa-solid fa-certificate text-amber-600 mb-1.5 text-base block"></i>
                            <p class="text-xs font-bold text-[#2B231D]">100% Authentic</p>
                            <p class="text-[11px] text-[#675B50]">Direct from Bihar craft clusters</p>
                        </div>
                    </div>
                </div>

                <!-- Interactive Purchase / WhatsApp Inquiry Area -->
                <div class="pt-6 border-t border-[#F2ECE0] space-y-3">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://api.whatsapp.com/send/?phone=919570479650&text=Hello+LittlePicassos!+I+am+interested+in+ordering+{{ urlencode($product->name) }}" target="_blank" 
                           class="flex-1 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white font-bold text-xs shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Inquire & Order on WhatsApp</span>
                        </a>

                        <a href="{{ route('shop.index') }}" class="px-5 py-3.5 rounded-2xl bg-[#F8F4EC] hover:bg-[#EFE7D8] text-[#4A3B32] text-xs font-bold border border-[#DCCFBA] transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Continue Shopping</span>
                        </a>
                    </div>

                    <p class="text-[11px] text-[#8A7F73] text-center">
                        <i class="fa-solid fa-shield-halved text-[10px] mr-1 text-terracotta-500"></i> Protected customer checkout &bull; Direct artisan livelihood contribution.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products in Category -->
    @if($relatedProducts->count() > 0)
        <div class="space-y-6 pt-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-terracotta-600">You May Also Like</span>
                    <h2 class="text-lg sm:text-xl font-black text-[#2B231D] font-serif tracking-tight mt-0.5">More in {{ $product->category?->name }}</h2>
                </div>
                <a href="{{ route('shop.index', ['category' => $product->category?->slug]) }}" class="text-xs font-bold text-terracotta-600 hover:text-terracotta-700 flex items-center gap-1">
                    <span>View All Category</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="artisan-card rounded-2xl overflow-hidden group transition duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative aspect-square overflow-hidden bg-[#F8F4EC]">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-[#2B231D] text-sm group-hover:text-terracotta-600 transition font-serif line-clamp-1">
                                    <a href="{{ route('shop.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <p class="text-xs font-bold text-[#2B231D] mt-1">₹{{ number_format($rel->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('shop.show', $rel->slug) }}" class="block w-full py-2 rounded-xl bg-[#F8F4EC] hover:bg-terracotta-500 text-[#4A3B32] hover:text-white text-xs font-bold text-center border border-[#E0D8C8] hover:border-terracotta-500 transition">
                                View Artwork
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
