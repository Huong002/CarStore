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
                'name' => 'Chào mừng',
                'content' => 'Chào mừng bạn đến với hệ thống!',
                'user_id' => 1,
            ],
            [
                'name' => 'Đơn hàng mới',
                'content' => 'Bạn có một đơn hàng mới.',
                'user_id' => 2,
            ],
            [
                'name' => 'Cập nhật tài khoản',
                'content' => 'Thông tin tài khoản đã được cập nhật.',
                'user_id' => 1,
            ],
        ];

        foreach ($notifications as $data) {
            Notification::create($data);
        }
    }
}
