<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Table;

class TablesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_tables_api_endpoints()
    {
        // 1) GET /tables/availability with date/time query params
        // (Adjust date/time as needed)
        $availabilityUrl = '/api/tables/availability?date=2025-04-10&time=12:00';
        $availabilityResponse = $this->getJson($availabilityUrl);
        $availabilityResponse->assertStatus(200);

        // 2) GET /tables-data
        $tablesDataResponse = $this->getJson('/api/tables-data');
        $tablesDataResponse->assertStatus(200);

        // 3) POST /tables (create a new table)
        // Adjust fields if your 'tables' table or validation rules require them.
        $createPayload = [
            'name'     => 'My Test Table',
            'capacity' => 4,
            'location' => 'Indoor', // if required
            // Add any other required fields here
        ];
        $createResponse = $this->postJson('/api/tables', $createPayload);
        // If your controller returns 201 on success:
        $createResponse->assertStatus(201); 
        $createResponse->assertJsonFragment([
            'name'     => 'My Test Table',
            'capacity' => 4,
            'location' => 'Indoor',
        ]);
        // Retrieve the new table ID from response (assuming you return it directly):
        $tableId = $createResponse->json('id');

        // 4) GET /tables/{id}
        $getSingleResponse = $this->getJson("/api/tables/{$tableId}");
        $getSingleResponse->assertStatus(200);
        $getSingleResponse->assertJsonFragment([
            'name' => 'My Test Table',
        ]);

        // 5) PUT /tables/{id} (update existing table)
        $updatePayload = [
            'name'     => 'Updated Name',
            'capacity' => 6,
            'location' => 'Outdoor', 
        ];
        $updateResponse = $this->putJson("/api/tables/{$tableId}", $updatePayload);
        $updateResponse->assertStatus(200);
        $updateResponse->assertJsonFragment([
            'name'     => 'Updated Name',
            'capacity' => 6,
            'location' => 'Outdoor',
        ]);

        // 6) DELETE /tables/{id}
        $deleteResponse = $this->deleteJson("/api/tables/{$tableId}");
        // Check the status your controller actually returns (200 or 204)
        $deleteResponse->assertStatus(200);

        // Make sure the record is removed
        $this->assertDatabaseMissing('tables', ['id' => $tableId]);
    }
}