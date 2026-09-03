@extends('layouts.admin')

@section('title', 'Edit Role: ' . $role->name)
@section('header_title', 'Edit Role: ' . $role->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb & Nav -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.roles.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Roles Matrix</span>
        </a>
    </div>

    <!-- Edit Role Form Card -->
    <div class="admin-card rounded-2xl p-6 sm:p-8">
        <div class="border-b border-slate-800 pb-5 mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-white tracking-tight">Edit Role: <span class="capitalize text-brand-400">{{ $role->name }}</span></h2>
                <p class="text-xs text-slate-400 mt-1">Update role settings and toggle system capabilities for this role.</p>
            </div>
            @if(in_array($role->name, ['admin', 'manager', 'customer']))
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-300 border border-amber-500/30">
                    System Core Role
                </span>
            @endif
        </div>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Role Name -->
            <div class="space-y-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                    Role Identifier <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" {{ $role->name === 'admin' ? 'readonly' : '' }} required
                       class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-white text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition placeholder-slate-500 {{ $role->name === 'admin' ? 'opacity-60 cursor-not-allowed' : '' }}">
                @if($role->name === 'admin')
                    <p class="text-[11px] text-amber-400">Core 'admin' identifier cannot be renamed, but permissions can be adjusted.</p>
                @endif
            </div>

            <!-- Permission Selection Matrix -->
            <div class="space-y-4 pt-4 border-t border-slate-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Assigned Granular Permissions</h3>
                        <p class="text-xs text-slate-400">Toggle the operations authorized for users holding this role.</p>
                    </div>

                    <!-- Quick Check/Uncheck Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="toggleAllCheckboxes(true)" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700 transition">
                            Select All
                        </button>
                        <button type="button" onclick="toggleAllCheckboxes(false)" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700 transition">
                            Deselect All
                        </button>
                    </div>
                </div>

                <!-- Grouped Permissions -->
                <div class="space-y-5 pt-2">
                    @foreach($groupedPermissions as $groupName => $groupPerms)
                        <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800/80 space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-800/60 pb-2">
                                <span class="text-xs font-bold text-brand-300 flex items-center gap-2">
                                    <i class="fa-solid fa-folder-closed text-[10px]"></i>
                                    {{ $groupName }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ count($groupPerms) }} permission(s)</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($groupPerms as $perm)
                                    @php
                                        $isChecked = in_array($perm->name, old('permissions', $rolePermissions));
                                    @endphp
                                    <label class="flex items-center gap-2.5 p-2 rounded-lg bg-slate-950/60 hover:bg-slate-900 border border-slate-800/50 cursor-pointer transition">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                               {{ $isChecked ? 'checked' : '' }}
                                               class="perm-checkbox w-4 h-4 rounded text-brand-600 bg-slate-900 border-slate-700 focus:ring-brand-500">
                                        <span class="text-xs font-medium {{ $isChecked ? 'text-white' : 'text-slate-400' }}">{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Save Role Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleAllCheckboxes(checked) {
        document.querySelectorAll('.perm-checkbox').forEach(cb => {
            cb.checked = checked;
        });
    }
</script>
@endpush
@endsection
