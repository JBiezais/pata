<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkOrder>
 */
class WorkOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->randomNumber(2, true),
            'title' => fake()->words(fake()->randomNumber(1), true),
            'description' => fake()->text,
            'image_path' => 'workorder/7FmRiCh8WcDq62AT7P6LHkxg5u16S1izAmlCZafx.jpg'
        ];
    }
}
