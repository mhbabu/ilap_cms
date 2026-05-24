<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'campus_id' => $attributes['campus_id'] ?? \App\Models\Campus::factory(),
            'source' => $this->faker->randomElement(['Website','Referral','Facebook','Walking','Phone']),
            'handler_id' => $attributes['handler_id'] ?? null, // optional
            'status' => $this->faker->randomElement(['new','contacted','qualified','disqualified','converted']),
            'is_flag' => $this->faker->boolean(),
        ];
    }
}