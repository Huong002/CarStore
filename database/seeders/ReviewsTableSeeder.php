<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('reviews')->insert([
            [
                'product_id' => 1, // Toyota Camry 2024
                'user_id' => 2, // Nguyễn Văn An
                'name' => 'Nguyễn Văn An',
                'email' => 'customer1@example.com',
                'content' => 'Xe chạy êm, tiết kiệm nhiên liệu, nội thất sang trọng.',
                'rating' => 5,
                'status' => 1, // 1 = hiển thị, 0 = ẩn
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 2, // Honda CR-V 2024
                'user_id' => 3, // Trần Thị Bình
                'name' => 'Trần Thị Bình',
                'email' => 'customer2@example.com',
                'content' => 'Rộng rãi, phù hợp cho gia đình. Tuy nhiên giá hơi cao.',
                'rating' => 4,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 3, // Mazda CX-5 2024
                'user_id' => 4, // Lê Minh Cường
                'name' => 'Lê Minh Cường',
                'email' => 'employee1@example.com',
                'content' => 'Thiết kế đẹp, cảm giác lái thể thao.',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}