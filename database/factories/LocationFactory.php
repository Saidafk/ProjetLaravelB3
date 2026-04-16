<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'film_id' => \App\Models\Film::factory(),
            'user_id' => \App\Models\User::factory(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'description' => fake()->paragraph(),
            'upvotes_count' => fake()->numberBetween(0, 10000),
        ];
    }
}
