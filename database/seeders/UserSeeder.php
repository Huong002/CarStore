<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Trần Phước Hưỡng',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'image' => 'avatar1.jpg',
                'utype' => 'ADM',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'USR',
                'image' => 'avatar2.jpg',
                'email_verified_at' => now(),
                'customer_id' => 1,
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'USR',
                'image' => 'avatar3.jpg',
                'email_verified_at' => now(),
                'customer_id' => 2,
            ],
            [
                'name' => 'Lê Minh Cường',
                'email' => 'employee1@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'USR',
                'image' => 'avatar4.jpg',
                'email_verified_at' => now(),
                'employee_id' => 1,  // Sửa: emplyee_id → employee_id
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
