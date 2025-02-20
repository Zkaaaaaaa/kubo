<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\History;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $employee;

    protected function setUp(): void
    {
        parent::setUp();

        // Simulasikan login sebagai employee
        $this->employee = User::factory()->create([
            'role' => 'employee',
        ]);
    }

    /** @test */
    public function test_displays_merged_histories()
    {
        // Arrange
        $this->actingAs($this->employee);

        // Buat data history dengan token yang sama
        $history1 = History::factory()->create([
            'token' => 'ABC123',
            'date' => now(),
            'product_id' => 1,
            'note' => 'Note 1',
            'total' => 100,
            'quantity' => 2,
            'status' => 'done',
            'table' => 'Table 1',
            'user_id' => $this->employee->id,
        ]);

        $history2 = History::factory()->create([
            'token' => 'ABC123',
            'date' => now(),
            'product_id' => 2,
            'note' => 'Note 2',
            'total' => 200,
            'quantity' => 3,
            'status' => 'done',
            'table' => 'Table 1',
            'user_id' => $this->employee->id,
        ]);

        // Buat history dengan token yang berbeda
        $history3 = History::factory()->create([
            'token' => 'XYZ789',
            'date' => now(),
            'product_id' => 3,
            'note' => 'Note 3',
            'total' => 150,
            'quantity' => 1,
            'status' => 'done',
            'table' => 'Table 2',
            'user_id' => $this->employee->id,
        ]);

        // Act
        $response = $this->get(route('employee.history.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('admin.history.index');
        $response->assertViewHas('histories', function ($histories) {
            return $histories->count() === 2 &&
                $histories->first()['token'] === 'ABC123' &&
                $histories->first()['total'] === 300 &&
                $histories->first()['quantity'] === 5 &&
                $histories->last()['token'] === 'XYZ789';
        });
    }
}
