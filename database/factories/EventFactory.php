<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+2 months');
        return [
            'name' => fake()->unique()->sentence(6, true),
            'description' => fake()->paragraph(5, true),
            'capacity' => random_int(10, 50),
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate, '+3 months')
        ];
    }
}
