<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Customer::create([
            'customerName' => 'Nguyễn Văn An',
            'email' => 'customer1@example.com',
            'address' => 'Hà Nội',
            'phone' => '0123456789',
            'gender' => 'Nam',
            'birthDay' => '1990-01-01'
        ]);
        Customer::create([
            'customerName' => 'Trần Thị Bình',
            'email' => 'customer2@example.com',
            'address' => 'HCM',
            'phone' => '0987654321',
            'gender' => 'Nữ',
            'birthDay' => '1992-02-02'
        ]);
    }
}
