<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Toyota Camry 2024',
                'slug' => Str::slug('Toyota Camry 2024'),
                'short_description' => 'Sedan hạng D cao cấp, tiết kiệm nhiên liệu',
                'description' => 'Toyota Camry 2024 với động cơ 2.5L, hộp số CVT, hệ thống an toàn Toyota Safety Sense 2.0, nội thất da cao cấp',
                'regular_price' => 1200000000, // 1.2 tỷ
                'sale_price' => 1150000000,   // 1.15 tỷ
                'SKU' => 'TC2024001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 15,
                'category_id' => 1, // Sedan
                'brand_id' => 1, // Toyota
            ],
            [
                'name' => 'Honda CR-V 2024',
                'slug' => Str::slug('Honda CR-V 2024'),
                'short_description' => 'SUV 7 chỗ gia đình thực dụng',
                'description' => 'Honda CR-V 2024 với động cơ VTEC Turbo 1.5L, 7 chỗ ngồi, cốp sau điện, camera 360 độ, Honda SENSING',
                'regular_price' => 1100000000, // 1.1 tỷ
                'sale_price' => 1050000000,   // 1.05 tỷ
                'SKU' => 'HCR2024001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 20,
                'category_id' => 2, // SUV
                'brand_id' => 2, // Honda
            ],
            [
                'name' => 'Mazda CX-5 2024',
                'slug' => Str::slug('Mazda CX-5 2024'),
                'short_description' => 'SUV 5 chỗ thể thao, thiết kế KODO',
                'description' => 'Mazda CX-5 2024 với động cơ SKYACTIV-G 2.5L, hệ thống i-ACTIVSENSE, nội thất da Nappa, âm thanh Bose',
                'regular_price' => 950000000, // 950 triệu
                'sale_price' => 920000000,   // 920 triệu
                'SKU' => 'MCX2024001',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 12,
                'category_id' => 2, // SUV
                'brand_id' => 3, // Mazda
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}