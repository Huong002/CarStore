<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Navy Blue', 'colorCode' => '#1E3A8A'],
            ['name' => 'Yellow', 'colorCode' => '#FBBF24'],
            ['name' => 'Black', 'colorCode' => '#000000'],
            ['name' => 'Gray Black', 'colorCode' => '#23272A'], // Đen xám
            ['name' => 'Silver', 'colorCode' => '#C0C0C0'], // Bạc
            ['name' => 'Light Blue', 'colorCode' => '#93C5FD'],
            ['name' => 'Chocolate Brown', 'colorCode' => '#8B4513'],
            ['name' => 'Tan Brown', 'colorCode' => '#D4A017'],
            ['name' => 'Light Pink', 'colorCode' => '#FBCFE8'],
            ['name' => 'Red', 'colorCode' => '#DC2626'],
            ['name' => 'Gray', 'colorCode' => '#9CA3AF'],
            ['name' => 'Mint Green', 'colorCode' => '#A7F3D0'],
            ['name' => 'Navy Blue', 'colorCode' => '#1E3A8A'],
            ['name' => 'Yellow', 'colorCode' => '#FBBF24'],
            ['name' => 'Black', 'colorCode' => '#000000'],
            ['name' => 'Light Blue', 'colorCode' => '#93C5FD'],
            ['name' => 'Chocolate Brown', 'colorCode' => '#8B4513'],
            ['name' => 'Tan Brown', 'colorCode' => '#D4A017'],
            ['name' => 'Light Pink', 'colorCode' => '#FBCFE8'],
            ['name' => 'Red', 'colorCode' => '#DC2626'],
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'name' => $color['name'],
                'colorCode' => $color['colorCode'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
