<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions and their role assignments.
     */
    public function index(Request $request): View
    {
        $query = Permission::with('roles');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $permissions = $query->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::create([
            'name' => strtolower(trim($request->name)),
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', "Permission '{$permission->name}' created successfully.");
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $corePermissions = [
            'view-admin-panel',
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'manage-categories',
            'manage-users',
        ];

        if (in_array($permission->name, $corePermissions)) {
            return back()->with('error', "Core system permission '{$permission->name}' cannot be deleted.");
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $name = $permission->name;
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', "Permission '{$name}' deleted successfully.");
    }
}
