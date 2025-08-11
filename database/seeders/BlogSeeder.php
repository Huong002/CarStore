<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = BlogCategory::all();
        $users = User::all();

        $blogs = [
            [
                'title' => 'Toyota Camry 2024: Đánh giá chi tiết sedan hạng D hàng đầu',
                'slug' => 'toyota-camry-2024-danh-gia-chi-tiet',
                'content' => 'Toyota Camry 2024 tiếp tục khẳng định vị thế của mình trong phân khúc sedan hạng D với nhiều cải tiến đáng kể. Xe được trang bị động cơ 2.5L kết hợp với hệ thống hybrid, mang lại hiệu suất vượt trội và tiết kiệm nhiên liệu. Nội thất sang trọng với công nghệ hiện đại, hệ thống an toàn Toyota Safety Sense 2.0 tiêu chuẩn.',
                'featured_image' => 'toyota-camry-2024.jpg',
                'status' => 'published',
                'views_count' => rand(100, 1000)
            ],
            [
                'title' => 'Hướng dẫn bảo dưỡng xe định kỳ: 8 bước cơ bản mọi tài xế cần biết',
                'slug' => 'huong-dan-bao-duong-xe-dinh-ky',
                'content' => 'Bảo dưỡng xe định kỳ là việc vô cùng quan trọng để đảm bảo xe hoạt động ổn định và kéo dài tuổi thọ. Bài viết này sẽ hướng dẫn 8 bước bảo dưỡng cơ bản: kiểm tra dầu máy, thay lọc gió, kiểm tra áp suất lốp, bảo dưỡng hệ thống phanh, làm sạch động cơ và nhiều việc khác.',
                'featured_image' => 'bao-duong-xe.jpg',
                'status' => 'published',
                'views_count' => rand(50, 500)
            ],
            [
                'title' => 'Top 5 xe điện bán chạy nhất thị trường Việt Nam 2024',
                'slug' => 'top-5-xe-dien-ban-chay-nhat-2024',
                'content' => 'Thị trường xe điện Việt Nam đang phát triển mạnh mẽ với sự xuất hiện của nhiều thương hiệu trong nước và quốc tế. VinFast VF 8, VF 9 dẫn đầu về doanh số, tiếp theo là Tesla Model Y, Hyundai Kona Electric và BMW iX3. Mỗi mẫu xe đều có ưu điểm riêng về thiết kế, tầm di chuyển và giá cả.',
                'featured_image' => 'xe-dien-2024.jpg',
                'status' => 'published',
                'views_count' => rand(200, 800)
            ],
            [
                'title' => '10 mẹo lái xe an toàn trong mùa mưa bão',
                'slug' => '10-meo-lai-xe-an-toan-mua-mua-bao',
                'content' => 'Mùa mưa bão đặt ra nhiều thách thức cho việc lái xe. Bài viết chia sẻ 10 mẹo quan trọng: giảm tốc độ, tăng khoảng cách an toàn, kiểm tra lốp xe, sử dụng đèn chiếu sáng đúng cách, tránh vũng nước sâu, và cách xử lý khi xe bị trượt bánh.',
                'featured_image' => 'lai-xe-mua-mua.jpg',
                'status' => 'published',
                'views_count' => rand(150, 600)
            ],
            [
                'title' => 'Mazda CX-5 2024 vs Honda CR-V 2024: Cuộc đối đầu SUV 5 chỗ',
                'slug' => 'mazda-cx5-vs-honda-crv-2024',
                'content' => 'So sánh chi tiết hai mẫu SUV 5 chỗ hàng đầu phân khúc: Mazda CX-5 2024 và Honda CR-V 2024. Về thiết kế, CX-5 thể thao hơn trong khi CR-V thiên về sự thực dụng. Động cơ, trang bị và giá bán cũng được phân tích kỹ lưỡng để giúp khách hàng đưa ra lựa chọn phù hợp.',
                'featured_image' => 'mazda-cx5-vs-honda-crv.jpg',
                'status' => 'draft',
                'views_count' => 0
            ]
        ];

        foreach ($blogs as $index => $blogData) {
            Blog::create([
                'title' => $blogData['title'],
                'slug' => $blogData['slug'],
                'content' => $blogData['content'],
                'featured_image' => $blogData['featured_image'],
                'author_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'status' => $blogData['status'],
                'views_count' => $blogData['views_count']
            ]);
        }
    }
}
