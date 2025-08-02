<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'name' => 'Chào mừng khách hàng mới',
                'content' => 'Chào mừng bạn đến với hệ thống!',
                'type' => 'customer', // Dành cho khách hàng
            ],
            [
                'name' => 'Đơn hàng mới',
                'content' => 'Có một đơn hàng mới cần xử lý',
                'type' => 'employee', // Dành cho nhân viên
            ],
            [
                'name' => 'Báo cáo doanh thu',
                'content' => 'Báo cáo doanh thu tháng mới đã sẵn sàng',
                'type' => 'admin', // Dành cho admin
            ],
            [
                'name' => 'Cập nhật hệ thống',
                'content' => 'Hệ thống vừa được cập nhật tính năng mới',
                'type' => 'all', // Dành cho tất cả
            ],
        ];

        foreach ($notifications as $data) {
            Notification::create($data);
        }
        // test push for dev-huong
    }
}
