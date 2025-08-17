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
        // Order 1: 2 sản phẩm khác nhau
        OrderDetail::create([
            'order_id' => 1,
            'product_id' => 1, // BMW M5 Sedan 2010
            'quantity' => 1,
            'price' => 1100000000,
            'total' => 1100000000,
        ]);
        OrderDetail::create([
            'order_id' => 1,
            'product_id' => 2, // BMW ActiveHybrid 5 Sedan 2012
            'quantity' => 1,
            'price' => 1300000000,
            'total' => 1300000000,
        ]);

        // Order 2: 1 sản phẩm
        OrderDetail::create([
            'order_id' => 2,
            'product_id' => 3, // Audi TT RS Coupe 2012
            'quantity' => 1,
            'price' => 1900000000,
            'total' => 1900000000,
        ]);

        // Order 3: 2 sản phẩm giống nhau
        OrderDetail::create([
            'order_id' => 3,
            'product_id' => 2, // BMW ActiveHybrid 5 Sedan 2012
            'quantity' => 1,
            'price' => 1300000000,
            'total' => 1300000000,
        ]);

        // Order 4: 1 sản phẩm
        OrderDetail::create([
            'order_id' => 4,
            'product_id' => 4, // BMW X3 SUV 2012
            'quantity' => 1,
            'price' => 1900000000,
            'total' => 1900000000,
        ]);
    }
}
