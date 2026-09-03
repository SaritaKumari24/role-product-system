@extends('layouts.admin')

@section('title', 'System Dashboard')
@section('header_title', 'System Dashboard & Metrics')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-900/80 via-indigo-950/80 to-slate-900 border border-brand-500/20 p-6 sm:p-8">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-500/20 text-brand-300 border border-brand-500/30">
                        {{ auth()->user()->hasRole('admin') ? 'Administrator Console' : 'Manager Workspace' }}
                    </span>
                    <span class="text-xs text-slate-400">Authenticated via Spatie RBAC</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Welcome back, {{ auth()->user()->name }}!
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    @if(auth()->user()->hasRole('admin'))
                        You have full administrative privileges to manage products, categories, image crops, and assign roles to users.
                    @else
                        You have manager privileges to create and manage products, crop images, and organize categories.
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add New Product</span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-2">
                    <i class="fa-solid fa-folder-plus text-brand-400"></i>
                    <span>Add Category</span>
                </a>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Metric Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Products Stat -->
        <div class="admin-card rounded-2xl p-5 relative overflow-hidden group hover:border-brand-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</p>
                    <h3 class="text-2xl font-extrabold text-white mt-1">{{ $totalProducts }}</h3>
                    <p class="text-[11px] text-emerald-400 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-[9px]"></i> {{ $activeProducts }} Active in Store
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
        </div>

        <!-- Categories Stat -->
        <div class="admin-card rounded-2xl p-5 relative overflow-hidden group hover:border-brand-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Product Categories</p>
                    <h3 class="text-2xl font-extrabold text-white mt-1">{{ $totalCategories }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-tag text-[9px] text-indigo-400"></i> Active taxonomies
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-folder-tree"></i>
                </div>
            </div>
        </div>

        <!-- Users Stat -->
        <div class="admin-card rounded-2xl p-5 relative overflow-hidden group hover:border-brand-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Users</p>
                    <h3 class="text-2xl font-extrabold text-white mt-1">{{ $totalUsers }}</h3>
                    <p class="text-[11px] text-amber-400 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-users text-[9px]"></i> {{ $roleCounts['customer'] }} Customers
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Role Breakdown Stat -->
        <div class="admin-card rounded-2xl p-5 relative overflow-hidden group hover:border-brand-500/40 transition duration-300">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Role Distribution</p>
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300 flex items-center gap-1.5"><i class="fa-solid fa-crown text-[10px] text-amber-400"></i> Admins:</span>
                        <span class="font-bold text-white">{{ $roleCounts['admin'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300 flex items-center gap-1.5"><i class="fa-solid fa-user-tie text-[10px] text-emerald-400"></i> Managers:</span>
                        <span class="font-bold text-white">{{ $roleCounts['manager'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300 flex items-center gap-1.5"><i class="fa-solid fa-user text-[10px] text-sky-400"></i> Customers:</span>
                        <span class="font-bold text-white">{{ $roleCounts['customer'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products & Recent Users Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Products (2 cols) -->
        <div class="lg:col-span-2 admin-card rounded-2xl p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                <div>
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-box text-brand-400"></i> Recent Products
                    </h3>
                    <p class="text-xs text-slate-400">Latest additions to the product catalog</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-brand-400 hover:text-brand-300 flex items-center gap-1">
                    <span>View All</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-800">
                            <th class="pb-3 font-semibold">Product</th>
                            <th class="pb-3 font-semibold">Category</th>
                            <th class="pb-3 font-semibold">Price</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($recentProducts as $prod)
                            <tr class="hover:bg-slate-900/40 transition">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-9 h-9 rounded-lg object-cover bg-slate-800 border border-slate-700">
                                        <div>
                                            <p class="font-semibold text-white truncate max-w-[180px]">{{ $prod->name }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $prod->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                                        {{ $prod->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="py-3 font-bold text-white">
                                    ${{ number_format($prod->price, 2) }}
                                </td>
                                <td class="py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $prod->status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        {{ ucfirst($prod->status) }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $prod) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-400 hover:bg-brand-500/10 transition" title="Edit Product">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        @role('admin')
                                            <form action="{{ route('admin.products.destroy', $prod) }}" method="POST" onsubmit="return confirm('Delete this product permanently?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition" title="Delete Product">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users (1 col) -->
        <div class="admin-card rounded-2xl p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                    <div>
                        <h3 class="text-base font-bold text-white flex items-center gap-2">
                            <i class="fa-solid fa-users text-amber-400"></i> Recent Users
                        </h3>
                        <p class="text-xs text-slate-400">Registered platform accounts</p>
                    </div>
                    @role('admin')
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-brand-400 hover:text-brand-300">Manage</a>
                    @endrole
                </div>

                <div class="space-y-3">
                    @foreach($recentUsers as $usr)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-900/50 border border-slate-800/80">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-200 flex-shrink-0">
                                    {{ strtoupper(substr($usr->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-white truncate">{{ $usr->name }}</p>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $usr->email }}</p>
                                </div>
                            </div>
                            <div>
                                @php $roleName = $usr->roles->first()?->name ?? 'customer'; @endphp
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $roleName === 'admin' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : ($roleName === 'manager' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-sky-500/10 text-sky-400 border border-sky-500/20') }}">
                                    {{ $roleName }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @role('admin')
                <div class="mt-4 pt-4 border-t border-slate-800">
                    <a href="{{ route('admin.users.index') }}" class="w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-users-gear text-amber-400"></i>
                        <span>Manage All Users & Roles</span>
                    </a>
                </div>
            @endrole
        </div>
    </div>
</div>
@endsection
