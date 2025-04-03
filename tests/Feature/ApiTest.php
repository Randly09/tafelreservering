<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Table;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /api/tables/availability endpoint.
     */
    public function test_table_availability_returns_json()
    {
        $response = $this->getJson('/api/tables/availability?date=2025-12-24&time=18:00');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'capacity', 'location']
        ]);
    }

    /**
     * Test GET /api/tables-data endpoint.
     */
    public function test_tables_data_returns_json()
    {
        Table::create([
            'name'     => 'Table 1',
            'capacity' => 4,
            'location' => 'Inside',
        ]);
        Table::create([
            'name'     => 'Table 2',
            'capacity' => 6,
            'location' => 'Outside',
        ]);

        $response = $this->getJson('/api/tables-data');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'capacity', 'location']
        ]);
    }

    /**
     * Test POST /api/tables endpoint.
     */
    public function test_create_table_returns_json()
    {
        $payload = [
            'name'     => 'New Table',
            'capacity' => 4,
            'location' => 'Inside'
        ];

        $response = $this->postJson('/api/tables', $payload);
        $response->assertStatus(201);
        $response->assertJsonFragment($payload);
        $this->assertDatabaseHas('tables', $payload);
    }

    /**
     * Test PUT /api/tables/{id} endpoint.
     */
    public function test_update_table_returns_json()
    {
        $table = Table::create([
            'name'     => 'Old Table',
            'capacity' => 4,
            'location' => 'Inside',
        ]);

        $payload = [
            'name'     => 'Updated Table',
            'capacity' => 6,
            'location' => 'Outside',
        ];

        $response = $this->putJson('/api/tables/' . $table->id, $payload);
        $response->assertStatus(200);
        $response->assertJsonFragment($payload);
        $this->assertDatabaseHas('tables', $payload);
    }

    /**
     * Test DELETE /api/tables/{id} endpoint.
     */
    public function test_delete_table_returns_json()
    {
        $table = Table::create([
            'name'     => 'Table to Delete',
            'capacity' => 4,
            'location' => 'Inside',
        ]);

        $response = $this->deleteJson('/api/tables/' . $table->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tables', ['id' => $table->id]);
    }
}

