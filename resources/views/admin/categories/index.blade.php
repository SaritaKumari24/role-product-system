@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('header_title', 'Category Taxonomies')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Product Categories</h2>
            <p class="text-xs text-slate-400 mt-0.5">Organize products into hierarchical departments and collections</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
            <i class="fa-solid fa-folder-plus"></i>
            <span>Add New Category</span>
        </a>
    </div>

    <!-- Search / Filter Bar -->
    <div class="admin-card rounded-2xl p-4">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search category by title or description..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs placeholder-slate-500 focus:border-brand-500 outline-none">
            </div>
            <button type="submit" class="px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-semibold transition">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs transition" title="Reset">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Categories Table -->
    <div class="admin-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/60 text-slate-400 border-b border-slate-800">
                        <th class="py-3.5 px-4 font-semibold">Category Name</th>
                        <th class="py-3.5 px-4 font-semibold">Slug Identifier</th>
                        <th class="py-3.5 px-4 font-semibold">Description</th>
                        <th class="py-3.5 px-4 font-semibold">Associated Products</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs font-bold">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <span class="font-bold text-white text-sm">{{ $cat->name }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400 text-[11px]">
                                {{ $cat->slug }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 max-w-xs truncate">
                                {{ $cat->description ?? 'No description provided.' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.products.index', ['category_id' => $cat->id]) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-800 hover:bg-slate-700 text-brand-300 border border-slate-700 transition">
                                    <i class="fa-solid fa-boxes-stacked text-[10px]"></i>
                                    <span>{{ $cat->products_count }} {{ Str::plural('product', $cat->products_count) }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="p-2 rounded-lg text-slate-300 hover:text-brand-400 hover:bg-brand-500/10 transition" title="Edit Category">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Deleting this category will affect related products. Proceed?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-300 hover:text-rose-400 hover:bg-rose-500/10 transition" title="Delete Category">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-600 block"></i>
                                <p class="text-sm font-semibold text-slate-300">No categories found</p>
                                <p class="text-xs text-slate-500 mt-1">Create your first product category to organize your catalog.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
