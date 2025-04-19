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
use Carbon\Carbon;

class HomePageControllerTest extends TestCase
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
        $response->assertViewHas('query', 'Test');
        $response->assertViewHas('categories');
    }

    public function test_homepage_loads_correctly()
    {
        $category = Category::factory()->create();
        $promo = Promo::factory()->create();
        $products = Product::factory(3)->create();

        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($viewProducts) use ($products) {
            return $viewProducts->count() === 3;
        });
        $response->assertViewHas('categories', function ($categories) use ($category) {
            return $categories->contains($category);
        });
        $response->assertViewHas('promo', $promo);
    }

    public function test_category_page_loads_correctly()
    {
        $category = Category::factory()->create();
        $products = Product::factory(2)->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->user)->get("/category/{$category->id}");

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($viewProducts) use ($products) {
            return $viewProducts->count() === 2;
        });
        $response->assertViewHas('category', $category);
        $response->assertViewHas('categories');
    }

    public function test_detail_product_page_loads_correctly()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->get("/detail-product/{$product->id}");

        $response->assertStatus(200);
        $response->assertViewHas('product', $product);
        $response->assertViewHas('categories');
    }

    public function test_add_to_cart_functionality()
    {
        $product = Product::factory()->create(['price' => 100]);
        $today = Carbon::now()->format('Y-m-d');
        $expectedToken = $this->user->id . '-' . $today;

        $response = $this->actingAs($this->user)->post("/cart/{$product->id}", [
            'note' => 'Test note',
            'quantity' => 2
        ]);

        $this->assertDatabaseHas('histories', [
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'note' => 'Test note',
            'quantity' => 2,
            'total' => 200,
            'status' => 'cart',
            'date' => $today,
            'token' => $expectedToken
        ]);

        $response->assertRedirect(route('cart'));
    }

    public function test_cart_page_loads_correctly()
    {
        $product = Product::factory()->create(['price' => 100]);
        $today = Carbon::now()->format('Y-m-d');
        $token = $this->user->id . '-' . $today;
        
        History::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'status' => 'cart',
            'date' => $today,
            'token' => $token,
            'total' => 200
        ]);

        $response = $this->actingAs($this->user)->get('/cart');

        $response->assertStatus(200);
        $response->assertViewHas('carts', function ($carts) {
            return $carts->count() === 1;
        });
        $response->assertViewHas('categories');
        $response->assertViewHas('snap_token');
    }

    public function test_finish_transaction_updates_status()
    {
        $product = Product::factory()->create(['price' => 100]);
        $today = Carbon::now()->format('Y-m-d');
        $token = $this->user->id . '-' . $today;
        
        History::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'status' => 'cart',
            'date' => $today,
            'token' => $token,
            'total' => 200
        ]);

        $requestData = [
            'result_data' => json_encode(['status_code' => 200]),
        ];

        $response = $this->actingAs($this->user)->post('/midtrans/finish', $requestData);

        $this->assertDatabaseHas('histories', [
            'user_id' => $this->user->id,
            'status' => 'process',
            'token' => $token,
            'total' => 200
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('client.finish');
        $response->assertViewHas('categories');
        $response->assertViewHas('message', 'Payment completed successfully.');
    }

    public function test_middleware_blocks_non_customers()
    {
        $nonCustomer = User::factory()->create(['role' => 'admin']);
        Auth::login($nonCustomer);

        $response = $this->get('/');

        $response->assertStatus(403);
    }

    public function test_my_orders_page_loads_correctly()
    {
        $product = Product::factory()->create();
        $today = Carbon::now()->format('Y-m-d');
        $token = $this->user->id . '-' . $today;

        History::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'status' => 'process',
            'date' => $today,
            'token' => $token,
            'total' => 200
        ]);

        $response = $this->actingAs($this->user)->get('/my-orders');

        $response->assertStatus(200);
        $response->assertViewHas('orders');
        $response->assertViewHas('categories');
    }

    public function test_order_detail_page_loads_correctly()
    {
        $product = Product::factory()->create();
        $today = Carbon::now()->format('Y-m-d');
        $token = $this->user->id . '-' . $today;

        $history = History::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'status' => 'process',
            'date' => $today,
            'token' => $token,
            'total' => 200
        ]);

        $response = $this->actingAs($this->user)->get("/order-detail/{$history->id}");

        $response->assertStatus(200);
        $response->assertViewHas('order');
        $response->assertViewHas('orderItems');
        $response->assertViewHas('categories');
    }
}
