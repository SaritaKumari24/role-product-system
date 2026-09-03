<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $manager;
    protected User $customer;
    protected Category $category;

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

        $this->category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and gadgets',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Guest & Customer Protection Tests
    |--------------------------------------------------------------------------
    */

    public function test_guest_is_redirected_when_accessing_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_customer_receives_403_forbidden_when_accessing_admin_dashboard(): void
    {
        $response = $this->actingAs($this->customer)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_customer_can_browse_product_catalog(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Test Smartphone',
            'slug' => 'test-smartphone',
            'description' => 'Great phone',
            'price' => 499.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->customer)->get(route('shop.index'));
        $response->assertStatus(200);
        $response->assertSee('Test Smartphone');
    }

    public function test_customer_can_view_single_product_details(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Flagship Tablet Pro',
            'slug' => 'flagship-tablet-pro',
            'description' => 'High performance tablet with OLED display',
            'price' => 699.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->customer)->get(route('shop.show', $product->slug));
        $response->assertStatus(200);
        $response->assertSee('Flagship Tablet Pro');
        $response->assertSee('High performance tablet');
    }

    public function test_customer_cannot_add_products_forbidden_403(): void
    {
        $response = $this->actingAs($this->customer)->post(route('admin.products.store'), [
            'name' => 'Unauthorized Product',
            'category_id' => $this->category->id,
            'price' => 99.00,
            'description' => 'Should fail',
            'status' => 'active',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', ['name' => 'Unauthorized Product']);
    }

    public function test_customer_cannot_edit_products_forbidden_403(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Existing Product',
            'slug' => 'existing-product',
            'price' => 50.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->customer)->put(route('admin.products.update', $product), [
            'name' => 'Hacked Product Name',
            'category_id' => $this->category->id,
            'price' => 10.00,
            'status' => 'active',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Existing Product',
        ]);
    }

    public function test_customer_cannot_delete_products_forbidden_403(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Undeletable Product',
            'slug' => 'undeletable-product',
            'price' => 75.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->customer)->delete(route('admin.products.destroy', $product));
        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    /*
    |--------------------------------------------------------------------------
    | Manager RBAC Capabilities & Restrictions Tests
    |--------------------------------------------------------------------------
    */

    public function test_manager_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->manager)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('System Dashboard');
    }

    public function test_manager_can_create_a_product(): void
    {
        $response = $this->actingAs($this->manager)->post(route('admin.products.store'), [
            'name' => 'Wireless Keyboard',
            'category_id' => $this->category->id,
            'price' => 79.99,
            'description' => 'Ergonomic mechanical keyboard',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Wireless Keyboard',
            'category_id' => $this->category->id,
            'price' => 79.99,
        ]);
    }

    public function test_manager_can_update_a_product(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Old Product Title',
            'slug' => 'old-product-title',
            'description' => 'Old description',
            'price' => 50.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->manager)->put(route('admin.products.update', $product), [
            'name' => 'Updated Product Title',
            'category_id' => $this->category->id,
            'price' => 65.00,
            'description' => 'Updated description',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Title',
            'price' => 65.00,
        ]);
    }

    public function test_manager_cannot_delete_product_forbidden_403(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Protected Product',
            'slug' => 'protected-product',
            'price' => 100.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->manager)->delete(route('admin.products.destroy', $product));
        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_manager_cannot_access_user_management(): void
    {
        $response = $this->actingAs($this->manager)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Full Capabilities Tests
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_delete_a_product(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Product To Be Deleted',
            'slug' => 'product-to-be-deleted',
            'price' => 120.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.products.destroy', $product));
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_can_access_user_management_and_update_roles(): void
    {
        $targetUser = User::factory()->create(['name' => 'Promoted User']);
        $targetUser->assignRole('customer');

        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertSee('System Users');

        // Update role to manager
        $patchResponse = $this->actingAs($this->admin)->patch(route('admin.users.updateRole', $targetUser), [
            'role' => 'manager',
        ]);

        $patchResponse->assertSessionHas('success');
        $this->assertTrue($targetUser->fresh()->hasRole('manager'));
    }

    public function test_admin_can_manage_categories(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Smart Home Gear',
            'description' => 'Automations and IoT sensors',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Smart Home Gear',
            'slug' => 'smart-home-gear',
        ]);
    }
}
