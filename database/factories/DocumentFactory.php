<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['guide','document','academic','certificate','ct_pipeline'];
        
        return [
            'title' => 'Demo Document ' . $this->faker->unique()->numberBetween(1, 999),
            'type' => $this->faker->randomElement($types),
            'is_guide_document' => $this->faker->boolean(),
            'uploaded_by' => $attributes['uploaded_by'] ?? \App\Models\User::factory(),
            'campus_id' => $attributes['campus_id'] ?? \App\Models\Campus::factory(),
            'size' => $this->faker->randomNumber(6), // random bytes up to 6 digits
            'mime' => $this->faker->randomElement(['application/pdf','application/msword']),
            'filename' => $this->faker->fileName(),
        ];
    }
}