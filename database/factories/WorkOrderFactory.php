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
            'user_id' => User::query()
                        ->select('id')
                        ->inRandomOrder()
                        ->first()->id,
            'title' => fake()->words(fake()->randomNumber(1), true),
            'description' => fake()->text,
            'image_path' => null
        ];
    }
}
