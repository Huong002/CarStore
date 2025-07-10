<?php

namespace Database\Seeders;
use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartItems = [
            [
                'cart_id' => 1,
                'product_id' => 1, 
                'quantity' => 1,
                'price' => 1150000000, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 1,
                'product_id' => 3, 
                'quantity' => 1,
                'price' => 920000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'cart_id' => 2,
                'product_id' => 2, 
                'quantity' => 2,
                'price' => 1050000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 2,
                'product_id' => 3, 
                'quantity' => 1,
                'price' => 2200000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'cart_id' => 3,
                'product_id' => 2, 
                'quantity' => 1,
                'price' => 2850000000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($cartItems as $itemData) {
            CartItem::create($itemData);
        }
    }
}
