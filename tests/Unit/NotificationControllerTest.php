<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\Employee\NotificationController;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $notification;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create([
            'role' => 'employee'
        ]);

        // Create a test notification
        $this->notification = DatabaseNotification::create([
            'id' => 'test-notification-id',
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => ['message' => 'Test notification'],
            'read_at' => null,
        ]);
    }

    /** @test */
    public function it_can_list_notifications()
    {
        // Act as the test user
        $this->actingAs($this->user);

        // Make request to index endpoint
        $response = $this->get(route('employee.notifications.index'));

        // Assert response
        $response->assertStatus(200);
        $response->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_mark_notification_as_read()
    {
        // Act as the test user
        $this->actingAs($this->user);

        // Make request to mark as read endpoint
        $response = $this->post(route('employee.notifications.markAsRead', $this->notification->id));

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Assert notification is marked as read
        $this->assertNotNull($this->notification->fresh()->read_at);
    }

    /** @test */
    public function it_can_mark_all_notifications_as_read()
    {
        // Act as the test user
        $this->actingAs($this->user);

        // Create multiple unread notifications
        DatabaseNotification::create([
            'id' => 'test-notification-2',
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => ['message' => 'Test notification 2'],
            'read_at' => null,
        ]);

        // Make request to mark all as read endpoint
        $response = $this->post(route('employee.notifications.markAllAsRead'));

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Assert all notifications are marked as read
        $this->assertEquals(0, $this->user->unreadNotifications->count());
    }

    /** @test */
    public function it_can_get_unread_notifications_count()
    {
        // Act as the test user
        $this->actingAs($this->user);

        // Make request to get unread count endpoint
        $response = $this->get(route('employee.notifications.getUnreadCount'));

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['count' => 1]);
    }

    /** @test */
    public function it_returns_404_when_marking_nonexistent_notification_as_read()
    {
        // Act as the test user
        $this->actingAs($this->user);

        // Make request with invalid notification ID
        $response = $this->post(route('employee.notifications.markAsRead', 'nonexistent-id'));

        // Assert response
        $response->assertStatus(404);
        $response->assertJson(['success' => false]);
    }
} 