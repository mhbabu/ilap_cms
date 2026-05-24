<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['tuition','installation','misc','refund','partial'];
        $statuses = ['pending','approved','rejected','completed'];
        
        return [
            'payer_id' => $attributes['payer_id'] ?? \App\Models\Student::factory(),
            'campus_id' => $attributes['campus_id'] ?? \App\Models\Campus::factory(),
            'amount' => $this->faker->numberBetween(100, 3000),
            'type' => $this->faker->randomElement($types),
            'status' => $this->faker->randomElement($statuses),
            'parent_payment_id' => null, // nullable
            'is_hq_visible' => true,
        ];
    }
}