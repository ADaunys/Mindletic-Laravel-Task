<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'time_slot_id' => TimeSlot::factory(),  // Create a time slot for the appointment
            'client_name' => $this->faker->name,
            'client_email' => $this->faker->unique()->safeEmail,
        ];
    }
}
