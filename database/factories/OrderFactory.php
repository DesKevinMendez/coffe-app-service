<?php

namespace Database\Factories;

use App\Models\{Commerce, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order' => $this->faker->numberBetween(1, 100),
            'total' => $this->faker->numberBetween(1, 6000),
            'user_id' => User::factory()->create()->id,
            'commerce_id' => Commerce::factory()->create()->id,
        ];
    }
}
