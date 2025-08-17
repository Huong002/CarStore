<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            ['BMW_2 _Series_3.jpg', true, 1], // BMW M5 Sedan 2010
            ['BMW_3 Series_10.jpg', false, 2],
             ['BMW_320i_12.jpg', true, 2],  // BMW ActiveHybrid 5 Sedan 2012
            ['BMW_320i_12.jpg', false, 3],
             ['BMW_4_Series_4.jpg', true, 3], // Audi TT RS Coupe 2012
            ['BMW_4_Series_4.jpg', true, 4], // ko nhan dien duoc
            ['BMW_750i_11.jpg', false, 4], // BMW X3 SUV 2012
            ['BMW_iX3_5.jpg', false, 1], // BMW M5 Sedan 2010
            ['BMW_Mpower_7.jpg', true, 5], // BMW 3 Series Wagon 2012
            ['BMW_M_6.jpg', false, 5], // ko nhan dien duoc
            ['BMW_X1_2.jpg', true, 6], // BMW X6 SUV 2012
            ['BMW_X3_8.jpg', false, 1], // BMW M5 Sedan 2010
            ['BMW_X5_1.jpg', true, 4], // BMW X3 SUV 2012
            ['BMW_X7_9.jpg', false, 5], // BMW 3 Series Wagon 2012
            ['Porsche_60th_Anniversary_911_ClubCoupe_Bonjourlife_2.jpg', false, 13], // Porsche 911 Turbo S 2022
            ['Porsche_718_Cayman_GTS_2018_9.jpg', false, 7],
             ['BMW_4_Series_4.jpg', true, 7], // Porsche Panamera Sedan 2012
            ['Porsche_911_GT3 2015_PTS_Fashion_Gray_3.jpg', false, 8],
             ['BMW_4_Series_4.jpg', true, 8], // Chevrolet Corvette ZR1 2012
            ['Porsche_911_Turbo_S_Cabriolet_1.jpg', true, 9], // Chevrolet Corvette Convertible 2012
            ['Porsche_918_Spyder_4.jpg', false, 13], // knhan dien duoc
            ['Porsche_991_GT3_Touring_2018_10.jpg', true, 10], // Mercedes-Benz SL-Class Coupe 2009
            ['Porsche_992_GT3_Touring_2022_11.jpg', false, 11], 
             ['BMW_4_Series_4.jpg', true, 11],// Volkswagen Beetle Hatchback 2012
            ['Porsche_996_Carrera_4S_2004_12.jpg', true, 12], // Jaguar XK XKR 2012
            ['Porsche_GT_3_Stance_5.jpg', false, 10], // Mercedes-Benz SL-Class Coupe 2009
            ['Porsche_Macan_7_7.jpg', true, 14], // ko nhan dien duoc
            ['Porsche_Macan_GTS_2020MY_6.jpg', false, 7], // Porsche Panamera Sedan 2012
            ['Porsche_turbo_GT_2022_8.jpg', true, 13], // ko nhan dien duoc
        ];

        foreach ($images as [$imageName, $isPrimary, $productId]) {
            DB::table('images')->insert([
                'imageName' => $imageName,
                'is_primary' => $isPrimary,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}