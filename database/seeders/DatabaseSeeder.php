<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                // Create users from the SQL dump
        $users = [
            [
                'first_name' => 'test',
                'last_name' => 'admin',
                'email' => 'testadmin@gmail.com',
                'phone' => '01843752377',
                'apartment' => 'A-2',
                'password' => Hash::make('1234'), // Using your original password
                'role' => 'admin',
            ],
            [
                'first_name' => 'Afifa',
                'last_name' => 'Ahmed',
                'email' => 'afifa@gmail.com',
                'phone' => '01879878999',
                'apartment' => 'A-2',
                'password' => Hash::make('1234'), // Using your original password
                'role' => 'member',
            ],
            [
                'first_name' => 'zawad',
                'last_name' => 'al munawar',
                'email' => 'zawad@gmail.com',
                'phone' => '01975180401',
                'apartment' => 'A-2',
                'password' => Hash::make('1234'), // Using your original password
                'role' => 'member',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Find by email
                $userData // Update or create with this data
            );
        }

        // Get the created users for inventory
        $zawad = User::where('email', 'zawad@gmail.com')->first();

        // Create inventory items from the SQL dump
        $inventoryItems = [
            [
                'user_id' => $zawad->id,
                'item_name' => 'Egg',
                'quantity' => 10.00,
                'unit' => 'pcs',
                'price' => 10.00,
                'threshold' => 1.00,
            ],
            [
                'user_id' => $zawad->id,
                'item_name' => 'fish',
                'quantity' => 12.00,
                'unit' => 'kg',
                'price' => 200.00,
                'threshold' => 15.00,
            ],
        ];

        foreach ($inventoryItems as $item) {
            Inventory::updateOrCreate(
                ['item_name' => $item['item_name'], 'user_id' => $item['user_id']], // Find by item and user
                $item // Update or create with this data
            );
        }

        // Create inventory requests from the SQL dump
        $inventoryRequests = [
            [
                'item_name' => 'Egg',
                'quantity' => 10.00,
                'unit_type' => 'pcs',
                'price' => 10.00,
                'threshold' => 1.00,
                'status' => 'approved',
                'requested_by' => $zawad->id,
                'requested_at' => '2025-05-06 09:09:48',
            ],
            [
                'item_name' => 'fish',
                'quantity' => 12.00,
                'unit_type' => 'kg',
                'price' => 200.00,
                'threshold' => 15.00,
                'status' => 'approved',
                'requested_by' => $zawad->id,
                'requested_at' => '2025-05-06 09:26:52',
            ],
            [
                'item_name' => 'fish',
                'quantity' => 12.00,
                'unit_type' => 'kg',
                'price' => 200.00,
                'threshold' => 15.00,
                'status' => 'approved',
                'requested_by' => $zawad->id,
                'requested_at' => '2025-05-06 10:08:37',
            ],
        ];

        foreach ($inventoryRequests as $request) {
            InventoryRequest::updateOrCreate(
                ['item_name' => $request['item_name'], 'requested_by' => $request['requested_by'], 'requested_at' => $request['requested_at']], // Find by unique combination
                $request // Update or create with this data
            );
        }
    }
}
