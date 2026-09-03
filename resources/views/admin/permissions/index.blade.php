@extends('layouts.admin')

@section('title', 'Permissions Matrix')
@section('header_title', 'Permissions Management')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-300 border border-amber-500/30">
                    <i class="fa-solid fa-key mr-1"></i> Granular Access Matrix
                </span>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight">System Permissions Directory</h2>
            <p class="text-xs text-slate-400 mt-0.5">Manage permissions that grant authorization across models, views, and controllers.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.roles.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold border border-slate-700 transition flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-brand-400"></i>
                <span>Manage Roles</span>
            </a>
        </div>
    </div>

    <!-- Create Custom Permission Card -->
    <div class="admin-card rounded-2xl p-5">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-2">Create Custom Permission</h3>
        <p class="text-xs text-slate-400 mb-4">Add a new granular capability (e.g. <code class="text-brand-300">export-reports</code>, <code class="text-brand-300">publish-articles</code>, <code class="text-brand-300">view-analytics</code>).</p>

        <form action="{{ route('admin.permissions.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <div class="flex-1">
                <input type="text" name="name" placeholder="e.g. manage-discounts, bulk-upload, refund-orders" required
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs placeholder-slate-500 focus:border-brand-500 outline-none">
            </div>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-md shadow-brand-600/30 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Add Permission</span>
            </button>
        </form>
    </div>

    <!-- Permissions Table -->
    <div class="admin-card rounded-2xl overflow-hidden">
        <div class="p-4 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h3 class="text-sm font-bold text-white">Registered Permissions ({{ $permissions->count() }})</h3>
            
            <form action="{{ route('admin.permissions.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter permissions..."
                       class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:border-brand-500 outline-none">
                <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold">Filter</button>
                @if(request('search'))
                    <a href="{{ route('admin.permissions.index') }}" class="p-1.5 text-slate-400 hover:text-white text-xs">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/60 text-slate-400 border-b border-slate-800">
                        <th class="py-3.5 px-4 font-semibold">Permission Identifier</th>
                        <th class="py-3.5 px-4 font-semibold">Guard</th>
                        <th class="py-3.5 px-4 font-semibold">Assigned To Roles</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($permissions as $permission)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-white text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-key text-amber-400 text-[10px]"></i>
                                    {{ $permission->name }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono text-[11px]">
                                {{ $permission->guard_name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($permission->roles as $role)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $role->name === 'admin' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/30' : ($role->name === 'manager' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/30' : 'bg-brand-500/10 text-brand-300 border border-brand-500/30') }}">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-500 italic">Unassigned to any role</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @php
                                    $isCore = in_array($permission->name, [
                                        'view-admin-panel', 'view-products', 'create-products',
                                        'edit-products', 'delete-products', 'manage-categories',
                                        'manage-users', 'manage-roles', 'manage-permissions'
                                    ]);
                                @endphp

                                @if($isCore)
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">System Core</span>
                                @else
                                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete custom permission {{ $permission->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white text-[11px] font-semibold transition">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-400">
                                No permissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
