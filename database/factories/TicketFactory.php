<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => 'Demo Ticket ' . $this->faker->unique()->numberBetween(1, 999),
            'type' => $this->faker->randomElement(['academic','finance','student','technical','other']),
            'priority' => $this->faker->randomElement(['low','medium','high','urgent']),
            'status' => $this->faker->randomElement(['open','in_progress','resolved','closed']),
            'created_by' => $attributes['created_by'] ?? \App\Models\User::factory(),
            'handler_id' => $attributes['handler_id'] ?? \App\Models\User::factory()->create(['role' => 'handler'])->id,
            'campus_id' => $attributes['campus_id'] ?? \App\Models\Campus::factory(),
            // ticket_number is auto-generated in model boot method
        ];
    }
}