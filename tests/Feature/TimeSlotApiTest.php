<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Psychologist;
use App\Models\TimeSlot;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TimeSlotApiTest extends TestCase
{
    use RefreshDatabase;

    // Test for adding a time slot for a psychologist
    public function test_add_time_slot_for_psychologist()
    {
        $psychologist = Psychologist::factory()->create();
        
        // Acting as the authenticated psychologist
        Sanctum::actingAs($psychologist);

        $response = $this->postJson('/api/psychologists/' . $psychologist->id . '/time-slots', [
            'start_time' => '2025-02-10 10:00:00',
            'end_time' => '2025-02-10 12:00:00',
        ]);

        // Check if the status code is 201 (created)
        $response->assertStatus(201);

        // Check if the time slot was added to the database
        $this->assertDatabaseHas('time_slots', [
            'psychologist_id' => $psychologist->id,
            'start_time' => '2025-02-10 10:00:00',
            'end_time' => '2025-02-10 12:00:00',
        ]);
    }

    public function test_view_available_time_slots()
    {
        $psychologist = Psychologist::factory()->create();

        $timeSlot = TimeSlot::create([
            'psychologist_id' => $psychologist->id,
            'start_time' => '2025-02-10 10:00:00',
            'end_time' => '2025-02-10 12:00:00',
        ]);

        $response = $this->getJson('/api/psychologists/' . $psychologist->id . '/time-slots');

        // Check if the status code is 200 (OK)
        $response->assertStatus(200);

        // Check if the time slot is present in the response
        $response->assertJsonFragment([
            'start_time' => '2025-02-10 10:00:00',
            'end_time' => '2025-02-10 12:00:00',
        ]);
    }
}
