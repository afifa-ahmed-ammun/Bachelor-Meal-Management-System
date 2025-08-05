<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        DB::table('users_table_updated')->updateOrInsert(
            ['email' => 'admin@test.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@test.com',
                'phone' => '01234567890',
                'apartment' => 'A-101',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'balance' => 1000.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Create member user
        DB::table('users_table_updated')->updateOrInsert(
            ['email' => 'member@test.com'],
            [
                'first_name' => 'Member',
                'last_name' => 'User',
                'email' => 'member@test.com',
                'phone' => '01987654321',
                'apartment' => 'B-202',
                'password' => Hash::make('member123'),
                'role' => 'member',
                'balance' => 500.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        echo "Test users created:\n";
        echo "Admin: admin@test.com / admin123\n";
        echo "Member: member@test.com / member123\n";
    }
}
