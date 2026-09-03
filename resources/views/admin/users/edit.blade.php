@extends('layouts.admin')

@section('title', 'Edit User Roles & Permissions: ' . $user->name)
@section('header_title', 'User Access & Permissions')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumbs -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to User Directory</span>
        </a>
    </div>

    <!-- Edit User Card -->
    <div class="admin-card rounded-2xl p-6 sm:p-8">
        <div class="border-b border-slate-800 pb-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-600/20 border border-brand-500/30 flex items-center justify-center font-black text-brand-300 text-base">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">{{ $user->name }}</h2>
                    <p class="text-xs text-slate-400">{{ $user->email }} &bull; Joined {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            @if($user->id === auth()->id())
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand-500/20 text-brand-300 border border-brand-500/30 self-start sm:self-auto">
                    <i class="fa-solid fa-user mr-1"></i> You (Current Session)
                </span>
            @endif
        </div>

        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Dynamic Role Selection -->
            <div class="space-y-3">
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                    Assign Dynamic Role <span class="text-rose-400">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($roles as $role)
                        <label class="relative flex flex-col p-4 rounded-xl border {{ $userRole === $role->name ? 'border-brand-500 bg-brand-500/10' : 'border-slate-800 bg-slate-900/60 hover:bg-slate-900' }} cursor-pointer transition">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-wide text-white">{{ $role->name }}</span>
                                <input type="radio" name="role" value="{{ $role->name }}" {{ $userRole === $role->name ? 'checked' : '' }}
                                       class="w-4 h-4 text-brand-600 bg-slate-900 border-slate-700 focus:ring-brand-500">
                            </div>
                            <span class="text-[11px] text-slate-400">
                                {{ $role->permissions->count() }} permissions assigned
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Direct User Custom Permissions -->
            <div class="space-y-4 pt-4 border-t border-slate-800">
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Direct / Custom User Permissions (Optional)</h3>
                    <p class="text-xs text-slate-400">Grant additional individual permissions directly to this user beyond their role.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($permissions as $perm)
                        @php
                            $hasDirect = in_array($perm->name, old('permissions', $userDirectPermissions));
                            $hasViaRole = $user->hasPermissionTo($perm->name);
                        @endphp
                        <label class="flex items-center gap-2.5 p-2.5 rounded-lg bg-slate-950/60 hover:bg-slate-900 border border-slate-800/60 cursor-pointer transition">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                   {{ $hasDirect ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-brand-600 bg-slate-900 border-slate-700 focus:ring-brand-500">
                            <div>
                                <span class="text-xs font-medium text-slate-200 block">{{ $perm->name }}</span>
                                @if($hasViaRole && !$hasDirect)
                                    <span class="text-[10px] text-emerald-400 flex items-center gap-1">
                                        <i class="fa-solid fa-check text-[8px]"></i> Inherited via role
                                    </span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Save User Role & Permissions</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
