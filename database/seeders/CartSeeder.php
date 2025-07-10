<?php
// filepath: d:\Dthu\heN3\php\laracvelecomerce\database\seeders\CartSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      $carts = [
         [
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'user_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
         ]
      ];

      foreach ($carts as $cartData) {
         Cart::create($cartData);
      }
   }
}
