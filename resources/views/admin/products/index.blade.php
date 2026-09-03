@extends('layouts.admin')

@section('title', 'Manage Products')
@section('header_title', 'Product Inventory')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Products Catalog</h2>
            <p class="text-xs text-slate-400 mt-0.5">Manage, filter, and organize all system products</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add New Product</span>
        </a>
    </div>

    <!-- Filters & Search Bar -->
    <div class="admin-card rounded-2xl p-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search -->
            <div class="sm:col-span-5 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name or keyword..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs placeholder-slate-500 focus:border-brand-500 outline-none">
            </div>

            <!-- Category Filter -->
            <div class="sm:col-span-3">
                <select name="category_id" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs focus:border-brand-500 outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="sm:col-span-2">
                <select name="status" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs focus:border-brand-500 outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-semibold transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category_id', 'status']))
                    <a href="{{ route('admin.products.index') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs transition" title="Reset Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="admin-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/60 text-slate-400 border-b border-slate-800">
                        <th class="py-3.5 px-4 font-semibold">Product</th>
                        <th class="py-3.5 px-4 font-semibold">Category</th>
                        <th class="py-3.5 px-4 font-semibold">Price</th>
                        <th class="py-3.5 px-4 font-semibold">Status</th>
                        <th class="py-3.5 px-4 font-semibold">Created</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($products as $prod)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3.5">
                                    <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-xl object-cover bg-slate-800 border border-slate-700 shadow-sm flex-shrink-0">
                                    <div>
                                        <a href="{{ route('shop.show', $prod->slug) }}" target="_blank" class="font-bold text-white hover:text-brand-400 transition text-sm">
                                            {{ $prod->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 max-w-md">
                                            {{ $prod->description ?? 'No description provided.' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-brand-500/10 text-brand-300 border border-brand-500/20">
                                    {{ $prod->category?->name ?? 'Unassigned' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-white text-sm">
                                ${{ number_format($prod->price, 2) }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $prod->status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                    <i class="fa-solid fa-circle text-[5px] mr-1.5 {{ $prod->status === 'active' ? 'text-emerald-400' : 'text-rose-400' }}"></i>
                                    {{ ucfirst($prod->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $prod->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit Action (Admin & Manager) -->
                                    <a href="{{ route('admin.products.edit', $prod) }}" class="p-2 rounded-lg text-slate-300 hover:text-brand-400 hover:bg-brand-500/10 transition" title="Edit Product">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <!-- Delete Action (Admin Only) -->
                                    @role('admin')
                                        <form action="{{ route('admin.products.destroy', $prod) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete \'{{ addslashes($prod->name) }}\'?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-300 hover:text-rose-400 hover:bg-rose-500/10 transition" title="Delete Product (Admin Only)">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="p-2 text-slate-600 cursor-not-allowed" title="Delete restricted to Admin role">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                        </span>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center mx-auto mb-3 text-slate-500 text-xl">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-300">No products found</p>
                                <p class="text-xs text-slate-500 mt-1">Try adjusting your search criteria or create a new product.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
