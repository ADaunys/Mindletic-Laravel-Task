<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Psychologist;
use App\Models\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_appointment()
    {
        // Use the factory to create a psychologist, time slot, and appointment
        $psychologist = Psychologist::factory()->create();
        $timeSlot = TimeSlot::factory()->create([
            'psychologist_id' => $psychologist->id,
        ]);

        // Create an appointment
        $appointment = Appointment::factory()->create([
            'time_slot_id' => 1,
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
        ]);

        // Make the API request
        $response = $this->postJson('/api/appointments', [
            'time_slot_id' => 1,
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
        ]);

        // Check if the status code is 201 (created)
        $response->assertStatus(201);

        // Check if the response contains success message
        $response->assertJsonStructure([
            'message',
            'appointment',
        ]);

        // Check if the appointment exists in the database
        $this->assertDatabaseHas('appointments', [
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
        ]);
    }
}
