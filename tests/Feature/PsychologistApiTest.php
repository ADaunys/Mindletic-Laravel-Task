<?php

namespace Tests\Feature;

use App\Models\Psychologist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PsychologistApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_psychologist()
    {
        // Use the factory to create a psychologist instance
        $psychologist = Psychologist::factory()->create([
            'name' => 'Dr. John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Dr. John Doe',
            'email' => 'john.doe@example.com',
        ]);

        // Check if the status code is 201
        $response->assertStatus(201);

        // Check if the response contains a token and a success message
        $response->assertJsonStructure([
            'message',
            'token',
        ]);

        // Check if the psychologist is stored in the database
        $this->assertDatabaseHas('psychologists', [
            'email' => 'john.doe@example.com',
        ]);
    }
}