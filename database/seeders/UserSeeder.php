<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Teachers
        User::create([
            'name' => 'John Teacher',
            'email' => 'teacher1@lms.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Jane Teacher',
            'email' => 'teacher2@lms.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Create Students
        User::create([
            'name' => 'Alice Student',
            'email' => 'student1@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Bob Student',
            'email' => 'student2@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Charlie Student',
            'email' => 'student3@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}