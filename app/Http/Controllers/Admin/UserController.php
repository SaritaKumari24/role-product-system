<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    /**
     * Display a listing of users and their assigned roles.
     */
    public function index(Request $request): View
    {
        $query = User::with(['roles', 'permissions']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show edit form for user roles and direct permissions.
     */
    public function edit(User $user): View
    {
        $user->load(['roles', 'permissions']);
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();
        $userRole = $user->roles->first()?->name ?? 'customer';
        $userDirectPermissions = $user->permissions->pluck('name')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'userRole', 'userDirectPermissions'));
    }

    /**
     * Update the specified user's role and direct permissions.
     */
    public function updateRole(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        // Prevent logged in user from demoting self if they are the current admin
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot remove your own administrator role.');
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Sync role dynamically
        $user->syncRoles([$request->role]);

        // Sync direct permissions if provided
        if ($request->has('permissions')) {
            $user->syncPermissions($request->input('permissions', []));
        }

        return back()->with('success', "Role & permissions for '{$user->name}' updated to '{$request->role}'.");
    }
}
