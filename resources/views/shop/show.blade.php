@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    <!-- Breadcrumbs & Quick Nav -->
    <div class="flex items-center justify-between">
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('shop.index', ['category' => $product->category?->slug]) }}" class="hover:text-white transition">
                {{ $product->category?->name ?? 'Catalog' }}
            </a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-slate-200 truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>

        @auth
            @if(auth()->user()->hasRole(['admin', 'manager']))
                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-600/20 text-brand-300 border border-brand-500/30 text-xs font-semibold hover:bg-brand-600 hover:text-white transition">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit in Admin Panel</span>
                </a>
            @endif
        @endauth
    </div>

    <!-- Product Showcase Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Left: Product Image Showcase -->
            <div class="lg:col-span-6 space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-xl text-xs font-bold bg-slate-950/80 backdrop-blur-md text-brand-300 border border-white/10 shadow-lg">
                            <i class="fa-solid fa-tag mr-1 text-brand-400"></i> {{ $product->category?->name ?? 'General' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Information & Attributes -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Product Title -->
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-snug">
                        {{ $product->name }}
                    </h1>

                    <!-- Price & Stock Status -->
                    <div class="flex items-center gap-4 mt-4 pb-6 border-b border-slate-800">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 block">Unit Price</span>
                            <span class="text-3xl font-extrabold text-white">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="pl-4 border-l border-slate-800">
                            <span class="text-xs font-semibold text-slate-400 block">Availability</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-400 mt-1">
                                <i class="fa-solid fa-circle-check"></i> In Stock & Active
                            </span>
                        </div>
                    </div>

                    <!-- Description Body -->
                    <div class="mt-6 space-y-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Product Details & Specs</h3>
                        <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'No detailed description provided for this product.' }}
                        </p>
                    </div>

                    <!-- Highlight Features -->
                    <div class="mt-8 grid grid-cols-2 gap-3">
                        <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800">
                            <i class="fa-solid fa-truck-fast text-brand-400 mb-1.5 text-base block"></i>
                            <p class="text-xs font-bold text-white">Fast Dispatch</p>
                            <p class="text-[11px] text-slate-400">Ships within 24-48 hours</p>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800">
                            <i class="fa-solid fa-shield-check text-emerald-400 mb-1.5 text-base block"></i>
                            <p class="text-xs font-bold text-white">Quality Guaranteed</p>
                            <p class="text-[11px] text-slate-400">Official brand product</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Interactive Area -->
                <div class="pt-6 border-t border-slate-800 space-y-3">
                    <div class="flex gap-3">
                        <button type="button" onclick="alert('Product added to customer bag simulation.')" class="flex-1 py-3.5 rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-sm shadow-xl shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>Add to Bag</span>
                        </button>
                        <a href="{{ route('shop.index') }}" class="px-5 py-3.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-slate-300 text-sm font-semibold border border-slate-700 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Continue Shopping</span>
                        </a>
                    </div>

                    <p class="text-[11px] text-slate-400 text-center">
                        <i class="fa-solid fa-lock text-[10px] mr-1"></i> Customer role: view-only access. Product modifications are managed by authorized Managers and Admins.
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
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight">More in {{ $product->category?->name }}</h2>
                    <p class="text-xs text-slate-400">Explore similar products in this department</p>
                </div>
                <a href="{{ route('shop.index', ['category' => $product->category?->slug]) }}" class="text-xs font-semibold text-brand-400 hover:text-brand-300 flex items-center gap-1">
                    <span>View Category</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="glass-card rounded-2xl overflow-hidden group hover:border-brand-500/40 transition duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative aspect-square overflow-hidden bg-slate-900">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-white text-sm group-hover:text-brand-300 transition line-clamp-1">
                                    <a href="{{ route('shop.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <p class="text-xs text-slate-400 mt-1 line-clamp-1">${{ number_format($rel->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('shop.show', $rel->slug) }}" class="block w-full py-1.5 rounded-lg bg-slate-900 hover:bg-brand-600 text-slate-300 hover:text-white text-xs font-medium text-center border border-slate-700 transition">
                                View Product
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
