<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\History;
use App\Models\Promo;
use Illuminate\Http\Request;

class HomepageControllerTest extends TestCase
{
    protected $user;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a default customer user
        $this->user = User::factory()->create(['role' => 'customer']);
        Auth::login($this->user);
    }

    public function test_search_functionality()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['name' => 'Test Product', 'category_id' => $category->id]);

        $response = $this->actingAs($this->user)->get('/search?query=Test');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($products) use ($product) {
            return $products->contains($product);
        });
    }

    public function test_homepage_loads_correctly()
    {
        $category = Category::factory()->create();
        $promo = Promo::factory()->create();
        $products = Product::factory(3)->create();

        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertViewHas('categories');
        $response->assertViewHas('promo');
    }

    public function test_category_page_loads_correctly()
    {
        $category = Category::factory()->create();
        $products = Product::factory(2)->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->user)->get("/category/{$category->id}");

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertViewHas('category', $category);
    }

    // public function test_detail_product_page_loads_correctly()
    // {
    //     $product = Product::factory()->create();

    //     $response = $this->actingAs($this->user)->get("/product/{$product->id}");

    //     $response->assertStatus(200);
    //     $response->assertViewHas('product', $product);
    // }

    // public function test_add_to_cart_functionality()
    // {
    //     $product = Product::factory()->create(['price' => 100]);

    //     $response = $this->actingAs($this->user)->post("/cart/store/{$product->id}", [
    //         'note' => 'Test note',
    //         'quantity' => 2
    //     ]);

    //     $this->assertDatabaseHas('histories', [
    //         'user_id' => $this->user->id,
    //         'product_id' => $product->id,
    //         'note' => 'Test note',
    //         'quantity' => 2,
    //         'total' => 200,
    //         'status' => 'cart',
    //     ]);

    //     $response->assertRedirect('/cart');
    // }

    public function test_cart_page_loads_correctly()
    {
        $product = Product::factory()->create(['price' => 100]);
        History::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'status' => 'cart'
        ]);

        $response = $this->actingAs($this->user)->get('/cart');

        $response->assertStatus(200);
        $response->assertViewHas('carts');
    }

    // public function test_finish_transaction_updates_status()
    // {
    //     $product = Product::factory()->create(['price' => 100]);
    //     History::factory()->create([
    //         'user_id' => $this->user->id,
    //         'product_id' => $product->id,
    //         'quantity' => 2,
    //         'status' => 'cart'
    //     ]);

    //     $requestData = [
    //         'result_data' => json_encode(['status_code' => 200]),
    //     ];

    //     $response = $this->actingAs($this->user)->post('/finish', $requestData);

    //     $this->assertDatabaseHas('histories', [
    //         'user_id' => $this->user->id,
    //         'status' => 'process'
    //     ]);

    //     $response->assertStatus(200);
    //     $response->assertViewIs('client.finish');
    // }

    public function test_middleware_blocks_non_customers()
    {
        $nonCustomer = User::factory()->create(['role' => 'admin']);
        Auth::login($nonCustomer);

        $response = $this->get('/');

        $response->assertStatus(403);
    }
}
