<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductControllerTest extends TestCase
{
    protected $employee;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Simulasikan login sebagai employee
        $this->employee = User::factory()->create([
            'role' => 'employee',
        ]);
    }

    /** @test */
    public function test_shows_all_products()
    {
        // Arrange
        $this->actingAs($this->employee);
        Product::factory()->count(5)->create();

        // Act
        $response = $this->get(route('employee.product.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('products', Product::all());
    }

   /** @test */
public function test_stores_a_new_product()
{
    // Arrange
    $this->actingAs($this->employee);
    $category = Category::factory()->create();
    $data = [
        'name' => 'New Product',
        'category_id' => $category->id,
        'price' => 1000,
        'description' => 'Product description',
        'photo' => 'product.jpg',
    ];

    // Act
    $response = $this->post(route('employee.product.store'), $data);

    // Debug response (optional)
    $response->dump();

    // Assert
    $response->assertRedirect(route('employee.product.index'));
    $this->assertDatabaseHas('products', [
        'name' => 'New Product',
        'category_id' => $category->id,
        'price' => 1000,
        'description' => 'Product description',
        'photo' => UploadedFile::fake()->image('product.jpg'),
    ]);
}

/** @test */
public function test_updates_an_existing_product()
{
    // Arrange
    $this->actingAs($this->employee);
    $category = Category::factory()->create();
    $product = Product::factory()->create();
    $updatedData = [
        'name' => 'Updated Product',
        'category_id' => $category->id,
        'price' => 2000,
        'description' => 'Updated product description',
        'photo' => UploadedFile::fake()->image('product.jpg'),
    ];

    // Act
    $response = $this->put(route('employee.product.update', $product->id), $updatedData);

    // Debug response (optional)
    $response->dump();

    // Assert
    $response->assertRedirect(route('employee.product.index'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id, // Pastikan id produk tetap sama
        'name' => 'Updated Product',
        'category_id' => $category->id,
        'price' => 2000,
        'description' => 'Updated product description',
        'photo' => 'updated-product.jpg',
    ]);
}


    /** @test */
    public function test_deletes_a_product()
    {
        // Arrange
        $this->actingAs($this->employee);
        $product = Product::factory()->create();

        // Act
        $response = $this->delete(route('employee.product.destroy', $product->id));

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function test_blocks_non_employee_users()
    {
        // Arrange
        $nonemployee = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($nonemployee);

        // Act
        $response = $this->get(route('employee.product.index'));

        // Assert
        $response->assertStatus(403);
    }
}
