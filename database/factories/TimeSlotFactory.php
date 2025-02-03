<?php

namespace Database\Factories;

use App\Models\Psychologist;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeSlotFactory extends Factory
{
    protected $model = TimeSlot::class;

    public function definition()
    {
        return [
            'psychologist_id' => Psychologist::factory(),  // Create a psychologist for the time slot
            'start_time' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'end_time' => $this->faker->dateTimeBetween('+2 days', '+3 days'),
            'is_booked' => false,
        ];
    }
}
