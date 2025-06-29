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
                'name' => 'Xe sedan',
                'slug' => 'xe-sedan',
                'image' => 'sedan.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe SUV',
                'slug' => 'xe-suv',
                'image' => 'suv.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe hatchback',
                'slug' => 'xe-hatchback',
                'image' => 'hatchback.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe pickup',
                'slug' => 'xe-pickup',
                'image' => 'pickup.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe MPV',
                'slug' => 'xe-mpv',
                'image' => 'mpv.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe crossover',
                'slug' => 'xe-crossover',
                'image' => 'crossover.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe coupe',
                'slug' => 'xe-coupe',
                'image' => 'coupe.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe convertible',
                'slug' => 'xe-convertible',
                'image' => 'convertible.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe điện',
                'slug' => 'xe-dien',
                'image' => 'electric.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe hybrid',
                'slug' => 'xe-hybrid',
                'image' => 'hybrid.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe thể thao',
                'slug' => 'xe-the-thao',
                'image' => 'sports.jpg',
                'parent_id' => null,
            ],
            [
                'name' => 'Xe sang',
                'slug' => 'xe-sang',
                'image' => 'luxury.jpg',
                'parent_id' => null,
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}