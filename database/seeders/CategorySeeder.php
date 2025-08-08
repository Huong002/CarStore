<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sedan',
                'slug' => Str::slug('Sedan'),
                'image' => 'sedan.jpg',
                'parent_id' => null,
                'isDeleted' => false,
            ],
            [
                'name' => 'SUV',
                'slug' => Str::slug('SUV'),
                'image' => 'suv.jpg',
                'parent_id' => null,
                'isDeleted' => false,
            ],
            [
                'name' => 'Coupe',
                'slug' => Str::slug('Coupe'),
                'image' => 'Coupe.jpg',
                'parent_id' => null,
                'isDeleted' => false,
            ],
            [
                'name' => 'Convertible',
                'slug' => Str::slug('Convertible'),
                'image' => 'Convertible.jpg',
                'parent_id' => null,
                'isDeleted' => false,
            ],
            [
                'name' => 'Hatchback',
                'slug' => Str::slug('Hatchback'),
                'image' => 'Hatchback.jpg',
                'parent_id' => null,
                'isDeleted' => false,
            ],
            [
                'name' => 'Wagon',
                'slug' => Str::slug('Wagon'),
                'image' => 'wagon.jpg',
                'parent_id' => null,
                'isDeleted' => false,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'image' => $category['image'],
                'parent_id' => $category['parent_id'],
                'isDeleted' => $category['isDeleted'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
