<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'BMW',
                'slug' => Str::slug('BMW'),
                'image' => 'BMW.png',
                'isDeleted' => false,
            ],
            [
                'name' => 'Porsche',
                'slug' => Str::slug('Porsche'),
                'image' => 'Porsche.jpg',
                'isDeleted' => false,
            ],
            [
                'name' => 'Audi',
                'slug' => Str::slug('Audi'),
                'image' => 'Audi.jpg',
                'isDeleted' => false,
            ],
            [
                'name' => 'Chevrolet',
                'slug' => Str::slug('Chevrolet'),
                'image' => 'Chevrolet.jpg',
                'isDeleted' => false,
            ],
            [
                'name' => 'Mercedes-Benz',
                'slug' => Str::slug('Mercedes-Benz'),
                'image' => 'Mercedes-Benz.png',
                'isDeleted' => false,
            ],
            [
                'name' => 'Volkswagen',
                'slug' => Str::slug('Volkswagen'),
                'image' => 'Volkswagen.jpg',
                'isDeleted' => false,
            ],
            [
                'name' => 'Jaguar',
                'slug' => Str::slug('Jaguar'),
                'image' => 'Jaguar.jpg',
                'isDeleted' => false,
            ],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'image' => $brand['image'],
                'isDeleted' => $brand['isDeleted'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
