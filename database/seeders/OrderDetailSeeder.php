<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderDetail;
class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             // order_id = 1, product_id = 1, 2 đã tồn tại
             OrderDetail::create([
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 1000000,
                'total' => 1000000,
            ]);
            OrderDetail::create([
                'order_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 1100000,
                'total' => 1100000,
            ]);
            // Order 2
            OrderDetail::create([
                'order_id' => 2,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 1200000,
                'total' => 1200000,
            ]);
    }
}
