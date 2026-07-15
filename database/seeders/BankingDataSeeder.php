<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;

class BankingDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a simulated Bank Teller
        $teller = User::create([
            'name' => 'Sarah Namubiru',
            'email' => 'sarah@pridebank.co.ug',
            'password' => Hash::make('password'),
            'role' => 'Teller',
        ]);

        // 2. Create an IT Support Specialist
        $itStaff = User::create([
            'name' => 'Joel Muhanguzi',
            'email' => 'joel@pridebank.co.ug',
            'password' => Hash::make('password'),
            'role' => 'IT Support',
        ]);

        // 3. Seed a Critical Core Banking failure
        Ticket::create([
            'title' => 'Core Banking System (CBS) Timeout Error',
            'description' => 'Equipments at teller counter 2 are failing to commit cash deposit transactions to the database. Throwing 504 Gateway Timeout.',
            'category' => 'Core Banking System',
            'priority' => 'Critical',
            'status' => 'Open',
            'branch_location' => 'Kampala Main Branch',
            'user_id' => $teller->id,
            'assigned_to' => $itStaff->id, // Assigned to you
        ]);

        // 4. Seed a High Priority ATM failure
        Ticket::create([
            'title' => 'ATM Card Reader Jam',
            'description' => 'Lobby ATM 02 is retaining client cards and throwing hardware peripheral error logs.',
            'category' => 'ATM Hardware',
            'priority' => 'High',
            'status' => 'In Progress',
            'branch_location' => 'Jinja Branch',
            'user_id' => $teller->id,
            'assigned_to' => null, // Left open for assignment
        ]);
    }
}
