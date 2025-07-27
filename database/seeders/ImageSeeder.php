<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;
use Illuminate\Support\Carbon;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            // Product 1: Porsche 992 GT3 Touring 2022 (chính + phụ)
            [
                'imageName' => 'Porsche_992_GT3_Touring_2022_11.jpg',
                'is_primary' => true,
                'product_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'imageName' => 'Porsche_turbo_GT_2022_8.jpg',
                'is_primary' => false,
                'product_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Product 2: Porsche Macan GTS 2020MY
            [
                'imageName' => 'Porsche_Macan_GTS_2020MY_6.jpg',
                'is_primary' => true,
                'product_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'imageName' => 'Porsche_718_Cayman_GTS_2018_9.jpg',
                'is_primary' => false,
                'product_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Product 3: Porsche 918 Spyder
            [
                'imageName' => 'Porsche_918_Spyder_4.jpg',
                'is_primary' => true,
                'product_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'imageName' => 'BMW_X7_9.jpg',
                'is_primary' => false,
                'product_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // // Product 4: BMW X5
            // [
            //     'imageName' => 'Images_Product/BMW_X5_1.jpg',
            //     'is_primary' => true,
            //     'product_id' => 4,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'imageName' => 'Images_Product/Porsche 918 Spyder_4.jpg',
            //     'is_primary' => false,
            //     'product_id' => 4,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],

            // // Product 5: BMW Mpower
            // [
            //     'imageName' => 'Images_Product/BMW_Mpower_7.jpg',
            //     'is_primary' => true,
            //     'product_id' => 5,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'imageName' => 'Images_Product/BMW_3 Series_10.jpg',
            //     'is_primary' => false,
            //     'product_id' => 5,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],

            // // Product 6: BMW 320i
            // [
            //     'imageName' => 'Images_Product/BMW_320i_12.jpg',
            //     'is_primary' => true,
            //     'product_id' => 6,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'imageName' => 'Images_Product/BMW_iX3_5.jpg',
            //     'is_primary' => false,
            //     'product_id' => 6,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],

            // // Product 7: BMW 3 Series
            // [
            //     'imageName' => 'Images_Product/BMW_3 Series_10.jpg',
            //     'is_primary' => true,
            //     'product_id' => 7,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'imageName' => 'Images_Product/BMW_320i_12.jpg',
            //     'is_primary' => false,
            //     'product_id' => 7,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
        ];

        foreach ($images as $image) {
            Image::create($image);
        }
    }
}