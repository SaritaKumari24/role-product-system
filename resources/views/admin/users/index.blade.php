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
            <h2 class="text-xl font-bold text-white tracking-tight">System Users & RBAC Permissions</h2>
            <p class="text-xs text-slate-400 mt-0.5">View platform users and dynamically re-assign Spatie RBAC roles.</p>
        </div>
    </div>

    <!-- Search & Role Filter -->
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
                <select name="role" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-xs focus:border-brand-500 outline-none">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin Only</option>
                    <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager Only</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer Only</option>
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
                        <th class="py-3.5 px-4 font-semibold">Joined Date</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Assign Role</th>
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
                                @php $role = $user->roles->first()?->name ?? 'customer'; @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $role === 'admin' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/30' : ($role === 'manager' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/30' : 'bg-sky-500/10 text-sky-300 border border-sky-500/30') }}">
                                    <i class="fa-solid {{ $role === 'admin' ? 'fa-crown text-amber-400' : ($role === 'manager' ? 'fa-user-tie text-emerald-400' : 'fa-user text-sky-400') }}"></i>
                                    {{ $role }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($user->id === auth()->id())
                                    <span class="text-[11px] text-slate-500 italic pr-2">Current session</span>
                                @else
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="inline-flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-semibold focus:border-brand-500 outline-none">
                                            <option value="customer" {{ $user->hasRole('customer') ? 'selected' : '' }}>Customer</option>
                                            <option value="manager" {{ $user->hasRole('manager') ? 'selected' : '' }}>Manager</option>
                                            <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">
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
