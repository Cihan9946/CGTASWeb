<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles') ->insert([
            'id' => 1,
            'role_name' => "Super Admin",
            'is_active' => 1
        ]);
        DB::table('roles') ->insert([
            'id' => 2,
            'role_name' => "Admin",
            'is_active' => 1
        ]);
        DB::table('roles') ->insert([
            'id' => 3,
            'role_name' => "Client",
            'is_active' => 1
        ]);
    }
}
