<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();

        Role::create([
            # id = 1
            "name" => "SuperAdmin",
            "slug" => "super_admin",
        ]);
        Role::create([
            # id = 2
            "name" => "Admin",
            "slug" => "admin",
        ]);

        Role::create([
            # id = 3
            "name" => "User",
            "slug" => "user",
        ]);
    }
}
