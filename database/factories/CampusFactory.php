<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class CampusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['Manchester','Leeds','Liverpool','London','Birmingham'];
        $codes = ['MAN','LDS','LVP','LDN','BRM'];
        $primaryColors = ['#1e40af','#0d9488','#dc2626','#7c3aed','#d97706'];
        $secondaryColors = ['#3b82f6','#10b981','#f87171','#a78bfa','#fbbf24'];
        
        $index = $this->faker->numberBetween(0, 4);
        
        return [
            'name' => $names[$index],
            'code' => $codes[$index],
            'unique_code' => null, // auto-generated in model boot method
            'color_primary' => $primaryColors[$index],
            'color_secondary' => $secondaryColors[$index],
            'is_active' => true,
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
        ];
    }
}