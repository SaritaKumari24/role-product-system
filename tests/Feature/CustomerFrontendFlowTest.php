<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerFrontendFlowTest extends TestCase
{
    use RefreshDatabase;

    protected Category $category;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $this->category = Category::create([
            'name' => 'Madhubani Art',
            'slug' => 'madhubani-art',
            'description' => 'Authentic hand-painted folk paintings',
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Peacock in Bloom Painting',
            'slug' => 'peacock-in-bloom-painting',
            'description' => 'Masterpiece painted with natural pigments on handmade paper.',
            'price' => 1500.00,
            'image' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=800',
            'status' => 'active',
        ]);
    }

    /**
     * Test complete customer journey:
     * Register -> Login -> View Listings -> View Details -> Logout
     */
    public function test_customer_complete_frontend_journey(): void
    {
        // 1. Customer Registration
        $registerResponse = $this->post('/register', [
            'name' => 'Sunita Sharma',
            'email' => 'sunita@example.com',
            'password' => 'artisanPass123',
            'password_confirmation' => 'artisanPass123',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'sunita@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('customer'));
        $registerResponse->assertRedirect(route('shop.index'));

        // 2. Customer Logout
        $logoutResponse = $this->actingAs($user)->post('/logout');
        $this->assertGuest();
        $logoutResponse->assertRedirect('/');

        // 3. Customer Login
        $loginResponse = $this->post('/login', [
            'email' => 'sunita@example.com',
            'password' => 'artisanPass123',
        ]);
        $this->assertAuthenticated();
        $loginResponse->assertRedirect(route('shop.index'));

        // 4. View Product Listings
        $listingResponse = $this->actingAs($user)->get(route('shop.index'));
        $listingResponse->assertStatus(200);
        $listingResponse->assertSee('Peacock in Bloom Painting');
        $listingResponse->assertSee('1,500.00');
        $listingResponse->assertSee('Details');
        // Must NOT see admin CRUD buttons
        $listingResponse->assertDontSee('Create New Product');
        $listingResponse->assertDontSee('Edit in Admin Panel');

        // 5. View Product Details
        $detailResponse = $this->actingAs($user)->get(route('shop.show', $this->product->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Peacock in Bloom Painting');
        $detailResponse->assertSee('Masterpiece painted with natural pigments');
        $detailResponse->assertSee('In Stock');
        $detailResponse->assertSee('Continue Shopping');
        // Must NOT see admin edit buttons
        $detailResponse->assertDontSee('Edit in Admin Panel');
    }

    /**
     * Test validation on customer registration
     */
    public function test_customer_registration_validation_rules(): void
    {
        // Duplicate email & mismatched password
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'existing@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'mismatchPass',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }

    /**
     * Test validation on customer login
     */
    public function test_customer_login_validation_and_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test customer restrictions: Cannot add, edit, or delete products or access admin APIs
     */
    public function test_customer_cannot_perform_any_product_crud(): void
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        // Cannot access product creation page
        $this->actingAs($customer)->get('/admin/products/create')->assertStatus(403);

        // Cannot add product (POST)
        $this->actingAs($customer)->post('/admin/products', [
            'name' => 'Illegal Product',
            'category_id' => $this->category->id,
            'price' => 200,
            'status' => 'active',
        ])->assertStatus(403);
        $this->assertDatabaseMissing('products', ['name' => 'Illegal Product']);

        // Cannot edit product (PUT)
        $this->actingAs($customer)->put("/admin/products/{$this->product->id}", [
            'name' => 'Tampered Name',
            'category_id' => $this->category->id,
            'price' => 10,
            'status' => 'active',
        ])->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $this->product->id, 'name' => 'Peacock in Bloom Painting']);

        // Cannot delete product (DELETE)
        $this->actingAs($customer)->delete("/admin/products/{$this->product->id}")->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $this->product->id]);

        // Cannot access user or role management
        $this->actingAs($customer)->get('/admin/users')->assertStatus(403);
        $this->actingAs($customer)->get('/admin/roles')->assertStatus(403);
    }
}
