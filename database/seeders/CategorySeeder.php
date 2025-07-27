<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Xe coupe',
                'slug' => 'xe-coupe',
                'image' => 'coupe.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe SUV',
                'slug' => 'xe-suv',
                'image' => 'suv.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe điện',
                'slug' => 'xe-dien',
                'image' => 'electric.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe thể thao',
                'slug' => 'xe-the-thao',
                'image' => 'sports.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe convertible',
                'slug' => 'xe-convertible',
                'image' => 'convertible.jpg',
                'parent_id' => null,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
