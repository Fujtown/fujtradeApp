<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Insert superadmin
      DB::table('admin')->insert([
        'username' => 'superadmin',
        'email' => 'superadmin@example.com',
        'password' => Hash::make('superadmin'), // Use a strong, unique password
        'is_admin' => '1',
        'user_type' => 'superadmin', // Assuming you have a 'user_type' column
        'created_at' => now(),
        'updated_at' => now(),
        // Include other fields as necessary
    ]);

    // Insert admin
    DB::table('admin')->insert([
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('admin'), // Use a strong, unique password
        'is_admin' => '2',
        'user_type' => 'admin', // Assuming you have a 'user_type' column
        'created_at' => now(),
        'updated_at' => now(),
        // Include other fields as necessary
    ]);

    // Insert agent
    DB::table('admin')->insert([
        'username' => 'agent',
        'email' => 'agent@example.com',
        'password' => Hash::make('agent'), // Use a strong, unique password
        'is_admin' => '3', // Assuming you have a 'user_type' column
        'user_type' => 'agent', // Assuming you have a 'user_type' column
        'created_at' => now(),
        'updated_at' => now(),
        // Include other fields as necessary
    ]);

    // Insert management
    DB::table('admin')->insert([
        'username' =>'management',
        'email' =>'management@example.com',
        'password' => Hash::make('management'), // Use a strong, unique password
        'is_admin' => '4', // Assuming you have a 'user_type' column
        'user_type' =>'management', // Assuming you have a 'user_type' column
        'created_at' => now(),
        'updated_at' => now(),
        // Include other fields as necessary
        ]);

     // Insert Member
    DB::table('admin')->insert([
        'username' =>'member',
        'email' =>'member@example.com',
        'password' => Hash::make('member'), // Use a strong, unique password
        'is_admin' => '5', // Assuming you have a 'user_type' column
        'user_type' =>'member', // Assuming you have a 'user_type' column
        'created_at' => now(),
        'updated_at' => now(),
        // Include other fields as necessary
        ]);
    }

}
