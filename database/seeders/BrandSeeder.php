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
            // Thương hiệu Nhật Bản
            [
                'name' => 'Toyota',
                'slug' => 'toyota',
                'image' => 'toyota.jpg',
            ],
            [
                'name' => 'Honda',
                'slug' => 'honda',
                'image' => 'honda.jpg',
            ],
            [
                'name' => 'Mazda',
                'slug' => 'mazda',
                'image' => 'mazda.jpg',
            ],
            [
                'name' => 'Nissan',
                'slug' => 'nissan',
                'image' => 'nissan.jpg',
            ],
            [
                'name' => 'Mitsubishi',
                'slug' => 'mitsubishi',
                'image' => 'mitsubishi.jpg',
            ],
            [
                'name' => 'Suzuki',
                'slug' => 'suzuki',
                'image' => 'suzuki.jpg',
            ],
            [
                'name' => 'Subaru',
                'slug' => 'subaru',
                'image' => 'subaru.jpg',
            ],
            [
                'name' => 'Lexus',
                'slug' => 'lexus',
                'image' => 'lexus.jpg',
            ],
            [
                'name' => 'Infiniti',
                'slug' => 'infiniti',
                'image' => 'infiniti.jpg',
            ],
            // Thương hiệu Hàn Quốc
            [
                'name' => 'Hyundai',
                'slug' => 'hyundai',
                'image' => 'hyundai.jpg',
            ],
            [
                'name' => 'Kia',
                'slug' => 'kia',
                'image' => 'kia.jpg',
            ],
            [
                'name' => 'Genesis',
                'slug' => 'genesis',
                'image' => 'genesis.jpg',
            ],
            // Thương hiệu Đức
            [
                'name' => 'Mercedes-Benz',
                'slug' => 'mercedes-benz',
                'image' => 'mercedes.jpg',
            ],
            [
                'name' => 'BMW',
                'slug' => 'bmw',
                'image' => 'bmw.jpg',
            ],
            [
                'name' => 'Audi',
                'slug' => 'audi',
                'image' => 'audi.jpg',
            ],
            [
                'name' => 'Volkswagen',
                'slug' => 'volkswagen',
                'image' => 'volkswagen.jpg',
            ],
            [
                'name' => 'Porsche',
                'slug' => 'porsche',
                'image' => 'porsche.jpg',
            ],
            // Thương hiệu Mỹ
            [
                'name' => 'Ford',
                'slug' => 'ford',
                'image' => 'ford.jpg',
            ],
            [
                'name' => 'Chevrolet',
                'slug' => 'chevrolet',
                'image' => 'chevrolet.jpg',
            ],
            [
                'name' => 'Cadillac',
                'slug' => 'cadillac',
                'image' => 'cadillac.jpg',
            ],
            [
                'name' => 'Tesla',
                'slug' => 'tesla',
                'image' => 'tesla.jpg',
            ],
            // Thương hiệu Pháp
            [
                'name' => 'Peugeot',
                'slug' => 'peugeot',
                'image' => 'peugeot.jpg',
            ],
            [
                'name' => 'Citroen',
                'slug' => 'citroen',
                'image' => 'citroen.jpg',
            ],
            // Thương hiệu Ý
            [
                'name' => 'Ferrari',
                'slug' => 'ferrari',
                'image' => 'ferrari.jpg',
            ],
            [
                'name' => 'Lamborghini',
                'slug' => 'lamborghini',
                'image' => 'lamborghini.jpg',
            ],
            // Thương hiệu Anh
            [
                'name' => 'Land Rover',
                'slug' => 'land-rover',
                'image' => 'landrover.jpg',
            ],
            [
                'name' => 'Jaguar',
                'slug' => 'jaguar',
                'image' => 'jaguar.jpg',
            ],
            // Thương hiệu Thụy Điển
            [
                'name' => 'Volvo',
                'slug' => 'volvo',
                'image' => 'volvo.jpg',
            ],
            // Thương hiệu Trung Quốc
            [
                'name' => 'VinFast',
                'slug' => 'vinfast',
                'image' => 'vinfast.jpg',
            ],
            [
                'name' => 'BYD',
                'slug' => 'byd',
                'image' => 'byd.jpg',
            ]
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }
    }
}