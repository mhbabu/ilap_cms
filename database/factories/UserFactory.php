<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        $roles = ['super_admin','hq_admin','campus_admin','campus_manager','handler','counsellor','student','parent'];
        
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'role' => $this->faker->randomElement($roles),
            'campus_id' => $attributes['campus_id'] ?? null, // optional
            'phone' => $this->faker->phoneNumber(),
            'nid_number' => $this->faker->numerify('##########'),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'is_active' => true,
            // unique_id is auto-generated in model boot method
        ];
    }
}