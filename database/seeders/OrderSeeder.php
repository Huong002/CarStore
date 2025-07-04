<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'customer_id' => 1,
            'employee_id' => 1,
            'tax' => 10000,
            'total' => 2100000,
            'status' => 'pending',
            'order_date' => now(),
            'total_item' => 2,
        ]);
        Order::create([
            'customer_id' => 2,
            'employee_id' => 1,
            'tax' => 5000,
            'total' => 1200000,
            'status' => 'completed',
            'order_date' => now(),
            'total_item' => 1,
        ]);
    }
}
