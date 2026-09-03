<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DynamicRolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $manager;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $this->admin = User::factory()->create(['name' => 'Admin User']);
        $this->admin->assignRole('admin');

        $this->manager = User::factory()->create(['name' => 'Manager User']);
        $this->manager->assignRole('manager');

        $this->customer = User::factory()->create(['name' => 'Customer User']);
        $this->customer->assignRole('customer');
    }

    public function test_admin_can_view_dynamic_roles_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.roles.index'));
        $response->assertStatus(200);
        $response->assertSee('System Roles');
        $response->assertSee('admin');
        $response->assertSee('manager');
        $response->assertSee('customer');
    }

    public function test_non_admin_cannot_view_roles_list(): void
    {
        $response = $this->actingAs($this->manager)->get(route('admin.roles.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_create_a_new_dynamic_role_with_permissions(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.roles.store'), [
            'name' => 'artisan_editor',
            'permissions' => ['view-products', 'edit-products', 'manage-categories'],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('roles', ['name' => 'artisan_editor']);
        $createdRole = Role::findByName('artisan_editor');
        $this->assertTrue($createdRole->hasPermissionTo('edit-products'));
        $this->assertTrue($createdRole->hasPermissionTo('manage-categories'));
        $this->assertFalse($createdRole->hasPermissionTo('delete-products'));
    }

    public function test_admin_can_update_role_permissions(): void
    {
        $customRole = Role::create(['name' => 'support_agent']);
        $customRole->syncPermissions(['view-products']);

        $response = $this->actingAs($this->admin)->put(route('admin.roles.update', $customRole), [
            'name' => 'support_agent_lead',
            'permissions' => ['view-products', 'edit-products'],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'support_agent_lead']);
        $this->assertTrue($customRole->fresh()->hasPermissionTo('edit-products'));
    }

    public function test_admin_can_delete_custom_role(): void
    {
        $customRole = Role::create(['name' => 'temporary_role']);

        $response = $this->actingAs($this->admin)->delete(route('admin.roles.destroy', $customRole));
        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseMissing('roles', ['name' => 'temporary_role']);
    }

    public function test_admin_cannot_delete_core_roles(): void
    {
        $adminRole = Role::findByName('admin');
        $response = $this->actingAs($this->admin)->delete(route('admin.roles.destroy', $adminRole));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
    }

    public function test_admin_can_view_and_create_custom_permissions(): void
    {
        $viewResponse = $this->actingAs($this->admin)->get(route('admin.permissions.index'));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('System Permissions Directory');

        $createResponse = $this->actingAs($this->admin)->post(route('admin.permissions.store'), [
            'name' => 'export-artisan-reports',
        ]);

        $createResponse->assertRedirect(route('admin.permissions.index'));
        $this->assertDatabaseHas('permissions', ['name' => 'export-artisan-reports']);
    }

    public function test_admin_can_assign_custom_dynamic_role_to_user(): void
    {
        $customRole = Role::create(['name' => 'curator']);
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->patch(route('admin.users.updateRole', $targetUser), [
            'role' => 'curator',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue($targetUser->fresh()->hasRole('curator'));
    }

    public function test_user_with_assigned_permissions_can_execute_actions(): void
    {
        $staffUser = User::factory()->create();
        $staffUser->givePermissionTo(['view-admin-panel', 'create-products', 'view-products']);

        $response = $this->actingAs($staffUser)->get('/admin');
        $response->assertStatus(200);
    }
}
