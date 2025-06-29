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
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'ADM',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'USR',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'USR',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Lê Minh Cường',
                'email' => 'customer3@example.com',
                'password' => Hash::make('password123'),
                'utype' => 'USR',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
