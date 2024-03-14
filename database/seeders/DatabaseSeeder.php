<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Sub_Domain;
use App\Models\Title;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this -> call([
            RoleSeeder::class
        ]);

        User::create([
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('123123123'),
            'name' => 'Super Admin',
            'role_id' => 1
        ]);

        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
            'name' => 'Admin',
            'role_id' => 2
        ]);

        User::create([
            'email' => 'firat@admin.com',
            'password' => Hash::make('123123123'),
            'name' => 'Admin',
            'role_id' => 2
        ]);


    }
}
