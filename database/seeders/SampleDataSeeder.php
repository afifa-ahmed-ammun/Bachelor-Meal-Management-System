<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user IDs
        $admin_id = DB::table('users_table_updated')->where('email', 'admin@test.com')->value('id');
        $member_id = DB::table('users_table_updated')->where('email', 'member@test.com')->value('id');

        // Sample Payments
        DB::table('payments')->insert([
            [
                'user_id' => $member_id,
                'amount' => 2000.00,
                'payment_method' => 'bkash',
                'transaction_id' => 'BKS123456789',
                'payment_details' => 'Payment for monthly meal subscription',
                'payment_date' => date('Y-m-d'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $member_id,
                'amount' => 1500.00,
                'payment_method' => 'nagad',
                'transaction_id' => 'NGD987654321',
                'payment_details' => 'Payment for extra meals',
                'payment_date' => date('Y-m-d', strtotime('-1 day')),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Sample Bazar Schedule
        DB::table('bazar_schedule')->insert([
            [
                'date' => date('Y-m-d', strtotime('+1 day')),
                'user_id' => $member_id,
                'status' => 'assigned',
                'budget' => 3000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'date' => date('Y-m-d', strtotime('+2 days')),
                'user_id' => null,
                'status' => 'pending',
                'budget' => 2500.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'date' => date('Y-m-d', strtotime('+3 days')),
                'user_id' => null,
                'status' => 'pending',
                'budget' => 2800.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Sample Inventory Requests
        DB::table('inventory_requests')->insert([
            [
                'user_id' => $member_id,
                'item_name' => 'Rice',
                'quantity' => 10.00,
                'unit_type' => 'kg',
                'price' => 600.00,
                'description' => 'Need quality rice for the month',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $member_id,
                'item_name' => 'Chicken',
                'quantity' => 3.00,
                'unit_type' => 'kg',
                'price' => 900.00,
                'description' => 'Fresh chicken for weekly meals',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Sample Meals
        DB::table('meals')->insert([
            [
                'user_id' => $member_id,
                'meal_date' => date('Y-m-d'),
                'meal_type' => 'lunch',
                'status' => 'scheduled',
                'cost' => 80.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $member_id,
                'meal_date' => date('Y-m-d'),
                'meal_type' => 'dinner',
                'status' => 'scheduled',
                'cost' => 120.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $member_id,
                'meal_date' => date('Y-m-d', strtotime('+1 day')),
                'meal_type' => 'lunch',
                'status' => 'scheduled',
                'cost' => 85.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        echo "Sample data created successfully!\n";
        echo "- 2 pending payments\n";
        echo "- 3 bazar schedule entries\n";
        echo "- 2 inventory requests\n";
        echo "- 3 scheduled meals\n";
    }
}
