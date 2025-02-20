<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCategoryControllerTest extends TestCase
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
    public function test_shows_all_categories()
    {
        // Arrange
        $this->actingAs($this->employee);
        Category::factory()->count(5)->create();

        // Act
        $response = $this->get(route('employee.category.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('categories', Category::all());
    }

    /** @test */
    public function test_stores_a_new_category()
    {
        // Arrange
        $this->actingAs($this->employee);
        $data = ['name' => 'New Category'];

        // Act
        $response = $this->post(route('employee.category.store'), $data);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function test_updates_an_existing_category()
    {
        // Arrange
        $this->actingAs($this->employee);
        $category = Category::factory()->create();
        $updatedData = ['name' => 'Updated Category'];

        // Act
        $response = $this->put(route('employee.category.update', $category->id), $updatedData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('categories', $updatedData);
    }

    /** @test */
    public function test_deletes_a_category()
    {
        // Arrange
        $this->actingAs($this->employee);
        $category = Category::factory()->create();

        // Act
        $response = $this->delete(route('employee.category.destroy', $category->id));

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
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
        $response = $this->get(route('employee.category.index'));

        // Assert
        $response->assertStatus(403);
    }
}
