<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Admin user instance for testing.
     *
     * @var User
     */
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Simulasikan login sebagai admin
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function it_shows_all_users()
    {
        // Arrange
        $this->actingAs($this->admin);
        User::factory()->count(5)->create();

        // Act
        $response = $this->get(route('admin.user.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('users', User::all());
    }

    /** @test */
    public function it_stores_a_new_user()
    {
        // Arrange
        $this->actingAs($this->admin);
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'employee',
            'password' => 'password123',
        ];

        // Act
        $response = $this->post(route('admin.user.store'), $data);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'employee',
        ]);
        $this->assertTrue(Hash::check('password123', User::where('email', 'john@example.com')->first()->password));
    }

    /** @test */
    public function it_updates_an_existing_user()
    {
        // Arrange
        $this->actingAs($this->admin);
        $user = User::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'customer',
            'password' => 'newpassword123',
        ];

        // Act
        $response = $this->put(route('admin.user.update', $user->id), $updatedData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'customer',
        ]);
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    /** @test */
    public function it_deletes_a_user()
    {
        // Arrange
        $this->actingAs($this->admin);
        $user = User::factory()->create();

        // Act
        $response = $this->delete(route('admin.user.destroy', $user->id));

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_blocks_non_admin_users()
    {
        // Arrange
        $nonAdmin = User::factory()->create([
            'role' => 'employee',
        ]);

        $this->actingAs($nonAdmin);

        // Act
        $response = $this->get(route('admin.user.index'));

        // Assert
        $response->assertStatus(403);
    }
}
