<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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