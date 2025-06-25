<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\DatabaseOrderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $employee;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->employee = User::factory()->create(['role' => 'employee']);
        $this->customer = User::factory()->create(['role' => 'customer']);
    }

    public function test_admin_can_view_notifications()
    {
        $response = $this->actingAs($this->admin)
            ->get('/notifications');

        $response->assertStatus(200);
        $response->assertViewHas('notifications');
    }

    public function test_employee_can_view_notifications()
    {
        $response = $this->actingAs($this->employee)
            ->get('/employee/notifications');

        $response->assertStatus(200);
        $response->assertViewHas('notifications');
    }

    public function test_mark_single_notification_as_read()
    {
        // Create a notification for the employee
        $notification = $this->employee->notifications()->create([
            'type' => DatabaseOrderNotification::class,
            'data' => [
                'message' => 'Test notification',
                'link' => '/employee/orders'
            ]
        ]);

        $response = $this->actingAs($this->employee)
            ->post("/employee/notifications/{$notification->id}/mark-as-read");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_mark_all_notifications_as_read()
    {
        // Create multiple notifications for the employee
        for ($i = 0; $i < 3; $i++) {
            $this->employee->notifications()->create([
                'type' => DatabaseOrderNotification::class,
                'data' => [
                    'message' => "Test notification {$i}",
                    'link' => '/employee/orders'
                ]
            ]);
        }

        $response = $this->actingAs($this->employee)
            ->post('/employee/notifications/mark-all-as-read');

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertEquals(0, $this->employee->unreadNotifications->count());
    }

    public function test_get_unread_notifications_count()
    {
        // Create some unread notifications
        for ($i = 0; $i < 5; $i++) {
            $this->employee->notifications()->create([
                'type' => DatabaseOrderNotification::class,
                'data' => [
                    'message' => "Test notification {$i}",
                    'link' => '/employee/orders'
                ]
            ]);
        }

        $response = $this->actingAs($this->employee)
            ->get('/employee/notifications/unread-count');

        $response->assertStatus(200);
        $response->assertJson(['count' => 5]);
    }

    public function test_order_notification_is_sent_to_employees()
    {
        Notification::fake();

        // Create a test order
        $order = [
            'user_id' => $this->customer->id,
            'product_id' => 1,
            'quantity' => 2,
            'total' => 100000,
            'status' => 'process',
            'token' => 'test-token'
        ];

        // Trigger the notification
        $this->actingAs($this->customer)
            ->post('/employee/orders', $order);

        // Assert that the notification was sent to all employees
        Notification::assertSentTo(
            [$this->employee],
            DatabaseOrderNotification::class
        );
    }
} 