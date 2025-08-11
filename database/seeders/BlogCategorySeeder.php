<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tin tức ô tô',
                'slug' => 'tin-tuc-o-to',
                'description' => 'Những tin tức mới nhất về thế giới ô tô, xu hướng và công nghệ mới'
            ],
            [
                'name' => 'Đánh giá xe',
                'slug' => 'danh-gia-xe',
                'description' => 'Đánh giá chi tiết các dòng xe mới, so sánh hiệu suất và tính năng'
            ],
            [
                'name' => 'Bảo dưỡng xe',
                'slug' => 'bao-duong-xe',
                'description' => 'Hướng dẫn bảo dưỡng, sửa chữa và chăm sóc xe ô tô'
            ],
            [
                'name' => 'Mẹo lái xe',
                'slug' => 'meo-lai-xe',
                'description' => 'Các mẹo và kỹ thuật lái xe an toàn, tiết kiệm nhiên liệu'
            ],
            [
                'name' => 'Thị trường ô tô',
                'slug' => 'thi-truong-o-to',
                'description' => 'Thông tin về thị trường ô tô, giá cả và xu hướng mua bán'
            ]
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}
