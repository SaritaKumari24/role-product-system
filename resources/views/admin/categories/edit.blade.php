@extends('layouts.admin')

@section('title', 'Edit Category')
@section('header_title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('admin.categories.index') }}" class="hover:text-white transition">Categories</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-200">Edit: {{ $category->name }}</span>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight">Edit Category: <span class="text-brand-400">{{ $category->name }}</span></h2>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs font-semibold text-slate-300 hover:text-white transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back</span>
        </a>
    </div>

    <!-- Category Form Card -->
    <div class="admin-card rounded-3xl p-6 sm:p-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-300 mb-1.5">Category Name <span class="text-rose-400">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 focus:border-brand-500 text-white text-sm placeholder-slate-500 outline-none">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-slate-300 mb-1.5">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 focus:border-brand-500 text-white text-sm placeholder-slate-500 outline-none resize-none">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Submit Actions -->
            <div class="border-t border-slate-800 pt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Update Category</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
