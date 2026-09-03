@extends('layouts.admin')

@section('title', 'User & Role Management')
@section('header_title', 'User & Role Management')

@section('content')
<div class="space-y-6">
    <!-- Header & Info -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-300 border border-amber-500/30">
                    <i class="fa-solid fa-crown mr-1"></i> Admin Privileges Only
                </span>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight">System Users & RBAC Assignments</h2>
            <p class="text-xs text-slate-400 mt-0.5">Manage platform user accounts and dynamically assign RBAC roles and permissions.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.roles.index') }}" class="px-3.5 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-semibold shadow-md shadow-brand-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Manage Dynamic Roles</span>
            </a>
        </div>
    </div>

    <!-- Search & Dynamic Role Filter -->
    <div class="admin-card rounded-2xl p-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-7 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user name or email..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs placeholder-slate-500 focus:border-brand-500 outline-none">
            </div>

            <div class="sm:col-span-3">
                <select name="role" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs focus:border-brand-500 outline-none capitalize">
                    <option value="">All Roles ({{ $roles->count() }})</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ request('role') === $r->name ? 'selected' : '' }}>
                            {{ ucfirst($r->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-semibold transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs transition" title="Reset">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="admin-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/60 text-slate-400 border-b border-slate-800">
                        <th class="py-3.5 px-4 font-semibold">User</th>
                        <th class="py-3.5 px-4 font-semibold">Email</th>
                        <th class="py-3.5 px-4 font-semibold">Current Role</th>
                        <th class="py-3.5 px-4 font-semibold">Permissions</th>
                        <th class="py-3.5 px-4 font-semibold">Joined Date</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-white text-xs">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-white text-sm flex items-center gap-1.5">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-brand-500/20 text-brand-300 border border-brand-500/30">You</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 font-mono text-[11px]">
                                {{ $user->email }}
                            </td>
                            <td class="py-3.5 px-4">
                                @php $userRoleName = $user->roles->first()?->name ?? 'customer'; @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $userRoleName === 'admin' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/30' : ($userRoleName === 'manager' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/30' : 'bg-sky-500/10 text-sky-300 border border-sky-500/30') }}">
                                    <i class="fa-solid {{ $userRoleName === 'admin' ? 'fa-crown text-amber-400' : ($userRoleName === 'manager' ? 'fa-user-tie text-emerald-400' : 'fa-user text-sky-400') }}"></i>
                                    {{ $userRoleName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-900 border border-slate-800 text-slate-300">
                                    {{ $user->getAllPermissions()->count() }} perms
                                </span>
                                @if($user->permissions->count() > 0)
                                    <span class="text-[10px] text-amber-400 font-medium ml-1">({{ $user->permissions->count() }} direct)</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id === auth()->id())
                                        <span class="text-[11px] text-slate-500 italic pr-2">Current session</span>
                                    @else
                                        <!-- Quick Role Switcher -->
                                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="inline-flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="px-2 py-1 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-semibold focus:border-brand-500 outline-none capitalize">
                                                @foreach($roles as $r)
                                                    <option value="{{ $r->name }}" {{ $user->hasRole($r->name) ? 'selected' : '' }}>
                                                        {{ ucfirst($r->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>

                                        <!-- Detailed Edit User Button -->
                                        <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white transition" title="Edit Direct Permissions">
                                            <i class="fa-solid fa-gear text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                No users found matching filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
