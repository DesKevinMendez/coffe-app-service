<?php

namespace Database\Factories;

use App\Models\{Commerce, User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1, 6000),
            'isUnit' => $this->faker->boolean(),
            'isActive' => $this->faker->boolean(),
            'isTemporary' => $this->faker->boolean(),
            'user_id' => User::factory()->create(),
            'commerce_id' => Commerce::factory()->create()
        ];
    }
}
