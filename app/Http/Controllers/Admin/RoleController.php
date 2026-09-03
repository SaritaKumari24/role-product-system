<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Display a listing of all roles and their assigned permissions.
     */
    public function index(Request $request): View
    {
        $query = Role::with(['permissions'])->withCount('users');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $roles = $query->orderBy('name')->get();
        $permissionsCount = Permission::count();

        return view('admin.roles.index', compact('roles', 'permissionsCount'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        $groupedPermissions = $this->groupPermissions($permissions);

        return view('admin.roles.create', compact('permissions', 'groupedPermissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        // Reset cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create([
            'name' => strtolower(trim($request->name)),
            'guard_name' => 'web',
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' created successfully with " . count($request->input('permissions', [])) . " permissions.");
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        $role->load('permissions');
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::orderBy('name')->get();
        $groupedPermissions = $this->groupPermissions($permissions);

        return view('admin.roles.edit', compact('role', 'rolePermissions', 'permissions', 'groupedPermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        // Reset cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Prevent renaming the core admin role
        if ($role->name === 'admin' && strtolower(trim($request->name)) !== 'admin') {
            return back()->with('error', 'The core administrator role name cannot be modified.');
        }

        $role->name = strtolower(trim($request->name));
        $role->save();

        // Sync permissions
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' updated successfully.");
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Prevent deleting core system roles
        if (in_array($role->name, ['admin', 'customer', 'manager'])) {
            return back()->with('error', "Core system role '{$role->name}' cannot be deleted.");
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Cannot delete role '{$role->name}' because {$role->users()->count()} user(s) are currently assigned to it. Please reassign them first.");
        }

        // Reset cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $name = $role->name;
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$name}' has been deleted successfully.");
    }

    /**
     * Helper to group permissions logically into readable modules.
     */
    private function groupPermissions($permissions)
    {
        $grouped = [
            'Product Management' => [],
            'Category Management' => [],
            'User & Role Management' => [],
            'System & Dashboard' => [],
            'Other Custom Permissions' => [],
        ];

        foreach ($permissions as $permission) {
            $name = $permission->name;

            if (str_contains($name, 'product')) {
                $grouped['Product Management'][] = $permission;
            } elseif (str_contains($name, 'categor')) {
                $grouped['Category Management'][] = $permission;
            } elseif (str_contains($name, 'user') || str_contains($name, 'role') || str_contains($name, 'permission')) {
                $grouped['User & Role Management'][] = $permission;
            } elseif (str_contains($name, 'admin') || str_contains($name, 'dashboard') || str_contains($name, 'system')) {
                $grouped['System & Dashboard'][] = $permission;
            } else {
                $grouped['Other Custom Permissions'][] = $permission;
            }
        }

        // Filter out empty groups
        return array_filter($grouped, fn($group) => count($group) > 0);
    }
}
