<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'film_id' => Film::factory(),
            'user_id' => User::factory(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'description' => fake()->paragraph(),
            'upvotes_count' => fake()->numberBetween(0, 10000),
        ];
    }
}
