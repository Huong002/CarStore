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
                'email' => 'psymint002@gmail.com',
                'password' => Hash::make('password123'),
                'image' => 'avatar1.jpg',
                'utype' => 'ADM',
                'email_verified_at' => now(),
                'employee_id' => 1,
            ],
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'CTM',
                'image' => 'avatar2.jpg',
                'email_verified_at' => now(),
                'customer_id' => 1,
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'CTM',
                'image' => 'avatar3.jpg',
                'email_verified_at' => now(),
                'customer_id' => 2,
            ],
            [
                'name' => 'Lê Minh Cường',
                'email' => 'employee1@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'EMP',
                'image' => 'avatar4.jpg',
                'email_verified_at' => now(),
                'employee_id' => 2,  
            ],
       
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
