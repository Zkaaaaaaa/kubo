<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate_using_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => 'customer' // Set role as customer
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home')); // This is correct for customer role
    }

    /** @test */
    public function admin_can_authenticate_using_valid_credentials()
    {
        $admin = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function employee_can_authenticate_using_valid_credentials()
    {
        $employee = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => 'employee'
        ]);

        $response = $this->post('/login', [
            'email' => $employee->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('employee.dashboard'));
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email'); // Laravel biasanya mengembalikan error pada email jika login gagal
    }

    /** @test */
    public function authenticated_users_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
