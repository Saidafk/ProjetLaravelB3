<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Film::factory(10)->create();

        Film::factory(10)->create([
            'title' => 'Test Film',
            'release_year' => 2023,
            'synopsis' => 'This is a test film.',
        ]);
    }
}
