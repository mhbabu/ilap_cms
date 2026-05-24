<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        $flow = ['registered','payment_pending','enrolled','documents_verified','completed'];
        
        return [
            'user_id' => $attributes['user_id'] ?? \App\Models\User::factory(),
            'campus_id' => $attributes['campus_id'] ?? \App\Models\Campus::factory(),
            'handler_id' => $attributes['handler_id'] ?? \App\Models\User::factory()->create(['role' => 'handler'])->id,
            'current_step' => $this->faker->randomElement($flow),
            'ielts_score' => $this->faker->randomFloat(1, 5, 9),
            'passport_number' => $this->faker->bothify('##########'),
            'date_of_birth' => $this->faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
        ];
    }
}