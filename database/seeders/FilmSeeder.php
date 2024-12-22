<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    public function run()
    {
        DB::table('films')->insert([
            [
                'name' => 'Inception',
                'director' => 'Christopher Nolan',
                'year' => 2010,
                'description' => 'A mind-bending thriller about dream invasion.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Godfather',
                'director' => 'Francis Ford Coppola',
                'year' => 1972,
                'description' => 'A classic tale of family, power, and betrayal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parasite',
                'director' => 'Bong Joon Ho',
                'year' => 2019,
                'description' => 'A gripping social satire that took the world by storm.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Dark Knight',
                'director' => 'Christopher Nolan',
                'year' => 2008,
                'description' => 'A groundbreaking superhero film about Batman vs Joker.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pulp Fiction',
                'director' => 'Quentin Tarantino',
                'year' => 1994,
                'description' => 'An iconic crime drama with intertwined stories.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
