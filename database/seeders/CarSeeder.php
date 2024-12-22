<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run()
    {
        DB::table('cars')->insert([
            [
                'make' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2021,
                'price' => 20000.00,
                'description' => 'Reliable and fuel-efficient sedan, perfect for daily commuting.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Ford',
                'model' => 'Mustang',
                'year' => 2020,
                'price' => 35000.00,
                'description' => 'Iconic sports car with powerful performance and sleek design.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Tesla',
                'model' => 'Model S',
                'year' => 2022,
                'price' => 79999.99,
                'description' => 'Luxury electric sedan with cutting-edge technology and range.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'price' => 18000.50,
                'description' => 'Compact car known for its durability and comfortable ride.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Chevrolet',
                'model' => 'Silverado',
                'year' => 2023,
                'price' => 45000.00,
                'description' => 'Powerful pickup truck built for tough jobs and off-road adventures.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
