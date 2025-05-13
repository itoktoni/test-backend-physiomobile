<?php

namespace Tests\Feature;

use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class PatientApiTest extends TestCase
{
    use RefreshDatabase;

    private string $accessKey;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        // Configure database
        DB::connection()->getPdo()->exec('PRAGMA foreign_keys=1;');

        $this->accessKey = config('services.api.access_key');
        $this->headers = ['X-API-Key' => $this->accessKey];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_cannot_access_api_without_access_key()
    {
        $this->getJson('/api/v1/patients')->assertStatus(401);
    }

    public function test_can_create_patient()
    {
        $patientData = [
            'name' => 'John Doe',
            'address' => '123 Main St',
            'id_type' => 'identity_card',
            'id_no' => '1234567890',
            'gender' => 'male',
            'dob' => '1990-08-15',
            'medium_acquisition' => 'walk_in'
        ];

        $this->postJson('/api/v1/patients', $patientData, $this->headers)
            ->assertStatus(201)
            ->assertJson(['name' => $patientData['name']]);

        $this->assertDatabaseHas('patients', $patientData);
    }

    public function test_can_list_patients()
    {
        Patient::factory(3)->create();

        $this->getJson('/api/v1/patients', $this->headers)
            ->assertStatus(200)
            ->assertJsonCount(3);
    }


    public function test_cannot_create_patient_with_invalid_data()
    {
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => '123',
            'address' => ''
        ];

        $this->postJson('/api/v1/patients', $invalidData, $this->headers)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'address']);
    }

    public function test_can_show_patient()
    {
        $patient = Patient::factory()->create();

        $this->getJson("/api/v1/patients/{$patient->id}", $this->headers)
            ->assertStatus(200)
            ->assertJson(['id' => $patient->id]);
    }

    public function test_can_update_patient()
    {
        $patient = Patient::factory()->create();
        $updateData = [
            'name' => 'Jane Doe Updated',
            'email' => 'jane.updated@example.com'
        ];

        $this->putJson("/api/v1/patients/{$patient->id}", $updateData, $this->headers)
            ->assertStatus(200)
            ->assertJson($updateData);

        $this->assertDatabaseHas('patients', $updateData);
    }

    public function test_can_delete_patient()
    {
        $patient = Patient::factory()->create();

        $this->deleteJson("/api/v1/patients/{$patient->id}", [], $this->headers)
            ->assertStatus(200);

        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }
}