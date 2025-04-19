<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DatabaseOrderNotification;
use Illuminate\Support\Facades\DB;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $orderData;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create user with employee role
        $this->user = User::factory()->create([
            'role' => 'employee'
        ]);
        
        $this->actingAs($this->user);

        // Setup common order data
        $this->orderData = (object)[
            'id' => 1,
            'token' => 'TEST123',
            'total' => 1000,
            'status' => 'pending'
        ];
    }

    public function test_index_returns_notifications_view()
    {
        // Create a notification directly in the database
        DB::table('notifications')->insert([
            'id' => uuid_create(),
            'type' => DatabaseOrderNotification::class,
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => json_encode([
                'order_id' => $this->orderData->id,
                'order_token' => $this->orderData->token,
                'total' => $this->orderData->total,
                'status' => $this->orderData->status,
                'message' => 'Test notification',
                'link' => '/employee/orders'
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $response = $this->get('/employee/notifications');

        $response->assertStatus(200)
            ->assertViewIs('admin.notifications.index')
            ->assertViewHas('notifications');
    }

    public function test_mark_as_read_updates_notification_status()
    {
        // Create a notification
        $notificationId = uuid_create();
        DB::table('notifications')->insert([
            'id' => $notificationId,
            'type' => DatabaseOrderNotification::class,
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => json_encode([
                'order_id' => $this->orderData->id,
                'order_token' => $this->orderData->token,
                'total' => $this->orderData->total,
                'status' => $this->orderData->status,
                'message' => 'Test notification',
                'link' => '/employee/orders'
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $response = $this->post("/employee/notifications/{$notificationId}/mark-as-read");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertNotNull(
            DB::table('notifications')
                ->where('id', $notificationId)
                ->value('read_at')
        );
    }

    public function test_mark_all_as_read_updates_all_notifications()
    {
        // Create multiple notifications
        for ($i = 0; $i < 3; $i++) {
            DB::table('notifications')->insert([
                'id' => uuid_create(),
                'type' => DatabaseOrderNotification::class,
                'notifiable_type' => User::class,
                'notifiable_id' => $this->user->id,
                'data' => json_encode([
                    'order_id' => $i + 1,
                    'order_token' => "TEST{$i}",
                    'total' => 1000,
                    'status' => 'pending',
                    'message' => "Test notification {$i}",
                    'link' => '/employee/orders'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $response = $this->post('/employee/notifications/mark-all-as-read');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $unreadCount = DB::table('notifications')
            ->where('notifiable_id', $this->user->id)
            ->whereNull('read_at')
            ->count();

        $this->assertEquals(0, $unreadCount);
    }

    public function test_mark_as_read_returns_404_for_invalid_notification()
    {
        $response = $this->post('/employee/notifications/invalid-uuid/mark-as-read');
        $response->assertStatus(404);
    }

    public function test_mark_as_read_returns_404_for_unauthorized_user()
    {
        // Create another user
        $otherUser = User::factory()->create([
            'role' => 'employee'
        ]);

        // Create notification for other user
        $notificationId = uuid_create();
        DB::table('notifications')->insert([
            'id' => $notificationId,
            'type' => DatabaseOrderNotification::class,
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'data' => json_encode([
                'order_id' => $this->orderData->id,
                'order_token' => $this->orderData->token,
                'total' => $this->orderData->total,
                'status' => $this->orderData->status,
                'message' => 'Test notification',
                'link' => '/employee/orders'
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Try to mark other user's notification as read
        $response = $this->post("/employee/notifications/{$notificationId}/mark-as-read");

        $response->assertStatus(404);
    }
} 