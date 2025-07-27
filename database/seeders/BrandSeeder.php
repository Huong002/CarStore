<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

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
                'slug' => 'bmw',
                'image' => 'bmw.jpg',
            ],
            [
                'name' => 'Porsche',
                'slug' => 'porsche',
                'image' => 'porsche.png',
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }
    }
}
