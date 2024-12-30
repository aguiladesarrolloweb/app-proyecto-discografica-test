<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            ['package_name' => 'paquete 1', 'format' => 'Dolby', 'songs_limit' => 1, 'price' => 49.00],
            ['package_name' => 'paquete 2', 'format' => 'Dolby', 'songs_limit' => 5, 'price' => 219.00],
            ['package_name' => 'paquete 3', 'format' => 'Dolby', 'songs_limit' => 10, 'price' => 399.00],
            ['package_name' => 'paquete 4', 'format' => 'Dolby', 'songs_limit' => 20, 'price' => 499.00],
            ['package_name' => 'paquete 5', 'format' => 'Dolby', 'songs_limit' => 50, 'price' => 1499.00],
            ['package_name' => 'paquete 6', 'format' => 'Dolby', 'songs_limit' => 100, 'price' => 2499.00],
        ];

        DB::table('package_types')->insert($packages);
    }
}
