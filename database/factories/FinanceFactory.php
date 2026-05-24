<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finance>
 */
class FinanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['one_time','installation','tution','partial','other'];
        $statuses = ['pending','completed','rejected'];
        $paymentMethods = ['cash','bank_transfer','credit_card','mobile_money','cheque'];
        
        return [
            'payer_id' => $attributes['payer_id'] ?? \App\Models\Student::factory(),
            'campus_id' => $attributes['campus_id'] ?? \App\Models\Campus::factory(),
            'amount' => $this->faker->numberBetween(500, 5000),
            'type' => $this->faker->randomElement($types),
            'status' => $this->faker->randomElement($statuses),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'initiated_by' => $attributes['initiated_by'] ?? \App\Models\User::factory(),
        ];
    }
}