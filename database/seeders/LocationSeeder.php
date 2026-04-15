<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Location::factory(10)->create();

        Location::factory(10)->create([
            'name' => 'Test Location',
            'film_id' => 1, 
            'user_id' => 1,
            'city' => 'Test City',
            'country' => 'Test Country',
            'description' => 'This is a test location.',
            'upvotes_count' => 0,
        ]);
    }
}
