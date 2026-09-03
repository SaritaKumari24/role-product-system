@extends('layouts.admin')

@section('title', 'Dynamic Role Management')
@section('header_title', 'Role Management')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-300 border border-amber-500/30">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Dynamic RBAC Engine
                </span>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight">System Roles & Permission Matrix</h2>
            <p class="text-xs text-slate-400 mt-0.5">Define dynamic roles and configure fine-grained permissions for users.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.permissions.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold border border-slate-700 transition flex items-center gap-2">
                <i class="fa-solid fa-key text-amber-400"></i>
                <span>View Permissions ({{ $permissionsCount }})</span>
            </a>
            <a href="{{ route('admin.roles.create') }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Create New Role</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="admin-card rounded-2xl p-4 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-medium text-slate-400">Total Configured Roles</p>
                <h3 class="text-2xl font-black text-white mt-1">{{ $roles->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 text-lg">
                <i class="fa-solid fa-user-shield"></i>
            </div>
        </div>

        <div class="admin-card rounded-2xl p-4 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-medium text-slate-400">Total System Permissions</p>
                <h3 class="text-2xl font-black text-white mt-1">{{ $permissionsCount }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-lg">
                <i class="fa-solid fa-key"></i>
            </div>
        </div>

        <div class="admin-card rounded-2xl p-4 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-medium text-slate-400">Active Role Users</p>
                <h3 class="text-2xl font-black text-white mt-1">{{ $roles->sum('users_count') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="admin-card rounded-2xl p-4">
        <form action="{{ route('admin.roles.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search roles by name..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs placeholder-slate-500 focus:border-brand-500 outline-none">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-semibold transition">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.roles.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs flex items-center">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Roles Grid / Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($roles as $role)
            <div class="admin-card rounded-2xl p-5 flex flex-col justify-between space-y-4 hover:border-brand-500/40 transition">
                <div>
                    <!-- Card Top: Name, Badge, Users count -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $role->name === 'admin' ? 'bg-amber-500/10 border border-amber-500/30 text-amber-400' : ($role->name === 'manager' ? 'bg-emerald-500/10 border border-emerald-500/30 text-emerald-400' : 'bg-brand-500/10 border border-brand-500/30 text-brand-400') }} flex items-center justify-center font-black text-sm">
                                <i class="fa-solid {{ $role->name === 'admin' ? 'fa-crown' : ($role->name === 'manager' ? 'fa-user-tie' : 'fa-user-shield') }}"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white capitalize flex items-center gap-2">
                                    {{ $role->name }}
                                    @if(in_array($role->name, ['admin', 'manager', 'customer']))
                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-slate-800 text-slate-400 border border-slate-700">Core Role</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Custom Dynamic</span>
                                    @endif
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    Assigned to <span class="text-brand-300 font-semibold">{{ $role->users_count }}</span> user(s)
                                </p>
                            </div>
                        </div>

                        <!-- Permissions Counter Pill -->
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-900 border border-slate-700 text-slate-300">
                            {{ $role->permissions->count() }} / {{ $permissionsCount }} permissions
                        </span>
                    </div>

                    <!-- Permissions tags -->
                    <div class="mt-4 pt-4 border-t border-slate-800/80">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Granted Permissions</p>
                        <div class="flex flex-wrap gap-1.5 max-h-28 overflow-y-auto pr-1">
                            @forelse($role->permissions as $perm)
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-medium bg-slate-900/90 text-slate-300 border border-slate-800">
                                    <i class="fa-solid fa-check text-emerald-400 mr-1 text-[8px]"></i>{{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">No permissions assigned yet.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="pt-3 border-t border-slate-800/60 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-mono">Guard: {{ $role->guard_name }}</span>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="px-3 py-1.5 rounded-lg bg-brand-600/20 hover:bg-brand-600 text-brand-300 hover:text-white text-xs font-semibold border border-brand-500/30 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                            <span>Edit Permissions</span>
                        </a>

                        @if(!in_array($role->name, ['admin', 'customer', 'manager']))
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete role {{ $role->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white text-xs font-semibold border border-rose-500/20 transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 admin-card rounded-2xl">
                <i class="fa-solid fa-shield-slash text-3xl mb-3 text-slate-600"></i>
                <p class="text-sm">No roles found matching your search.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
