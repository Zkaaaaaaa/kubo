<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $employee;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Simulasikan login sebagai employee
        $this->employee = User::factory()->create([
            'role' => 'employee',
        ]);

        // Buat category untuk digunakan di beberapa test
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function test_shows_all_products()
    {
        // Arrange
        $this->actingAs($this->employee);
        $products = Product::factory()->count(5)->create();
        $categories = Category::all();

        // Act
        $response = $this->get(route('employee.product.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('products', $products);
        $response->assertViewHas('categories', $categories);
    }

    /** @test */
    public function test_stores_new_product()
    {
        Storage::fake('public');

        $this->actingAs($this->employee);
        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->from(route('employee.product.index'))->post(route('employee.product.store'), [
            'name' => 'New Product',
            'category_id' => $this->category->id,
            'price' => 1000,
            'description' => 'Product description',
            'photo' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('employee.product.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'category_id' => $this->category->id,
            'description' => 'Product description',
            'price' => 1000,
        ]);

        $product = Product::where('name', 'New Product')->first();
        $this->assertNotNull($product->photo);
        $this->assertTrue(file_exists(public_path('storage/' . $product->photo)));
    }

    /** @test */
    public function test_store_validates_input()
    {
        $this->actingAs($this->employee);

        $response = $this->post(route('employee.product.store'), [
            'name' => '',
            'category_id' => '',
            'price' => 'invalid',
            'description' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'category_id', 'price', 'description']);
    }

    /** @test */
    public function test_updates_an_existing_product()
    {
        // Setup storage
        Storage::fake('public');
        if (!file_exists(public_path('storage'))) {
            mkdir(public_path('storage'), 0777, true);
        }

        $this->actingAs($this->employee);
        
        // Create initial product with photo
        $oldFileName = 'old-photo.jpg';
        $oldFilePath = public_path('storage/' . $oldFileName);
        file_put_contents($oldFilePath, 'test content');
        
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Original Product',
            'price' => 1000,
            'description' => 'Original description',
            'photo' => $oldFileName
        ]);

        $updatedFile = UploadedFile::fake()->image('updated-product.jpg');

        $response = $this->from(route('employee.product.index'))
            ->put(route('employee.product.update', $product->id), [
                'name' => 'Updated Product',
                'category_id' => $this->category->id,
                'price' => 2000,
                'description' => 'Updated product description',
                'photo' => $updatedFile,
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('employee.product.index'));
        $response->assertSessionHas('success', 'Berhasil');
        
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'category_id' => $this->category->id,
            'price' => 2000,
            'description' => 'Updated product description',
        ]);

        $updatedProduct = $product->fresh();
        $this->assertNotNull($updatedProduct->photo);
        $this->assertNotEquals($oldFileName, $updatedProduct->photo);
        $this->assertTrue(file_exists(public_path('storage/' . $updatedProduct->photo)));
        
        // Old file should be deleted
        $this->assertFalse(file_exists($oldFilePath));
    }

    /** @test */
    public function test_update_validates_input()
    {
        $this->actingAs($this->employee);
        $product = Product::factory()->create();

        $response = $this->put(route('employee.product.update', $product->id), [
            'name' => '',
            'category_id' => '',
            'price' => -1, // test min:0 validation
            'description' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'category_id', 'price', 'description']);
    }

    /** @test */
    public function test_deletes_a_product()
    {
        // Arrange
        $this->actingAs($this->employee);
        $product = Product::factory()->create([
            'name' => 'Product to delete'
        ]);

        // Act
        $response = $this->from(route('employee.product.index'))
            ->delete(route('employee.product.destroy', $product->id));

        // Assert
        $response->assertRedirect(route('employee.product.index'));
        $response->assertSessionHas('success', 'Berhasil hapus ' . $product->name);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function test_blocks_non_employee_users()
    {
        // Arrange
        $nonemployee = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->actingAs($nonemployee);

        // Act
        $response = $this->get(route('employee.product.index'));

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function test_photo_validation()
    {
        $this->actingAs($this->employee);

        // Test invalid file type
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100);
        $response = $this->post(route('employee.product.store'), [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 1000,
            'description' => 'Test description',
            'photo' => $invalidFile,
        ]);

        $response->assertSessionHasErrors('photo');

        // Test file too large (> 2048 KB)
        $largeFile = UploadedFile::fake()->image('large.jpg')->size(3000);
        $response = $this->post(route('employee.product.store'), [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 1000,
            'description' => 'Test description',
            'photo' => $largeFile,
        ]);

        $response->assertSessionHasErrors('photo');
    }
}
