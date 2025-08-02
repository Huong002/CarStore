<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = Notification::all();
        $users = User::all();

        // Tạo thông báo cho mỗi user dựa theo role
        foreach ($users as $user) {
            foreach ($notifications as $notification) {
                // Kiểm tra role của user và loại thông báo
                $shouldReceive = false;
                
                switch ($notification->type) {
                    case 'customer':
                        $shouldReceive = $user->utype === 'USR';
                        break;
                    case 'employee':
                        $shouldReceive = $user->employee_id !== null;
                        break;
                    case 'admin':
                        $shouldReceive = $user->utype === 'ADM';
                        break;
                    case 'all':
                        $shouldReceive = true;
                        break;
                }

                // Chỉ tạo thông báo nếu user thuộc đối tượng nhận
                if ($shouldReceive) {
                    UserNotification::create([
                        'isArchived' => false,
                        'isRead' => false,
                        'user_id' => $user->id,
                        'notification_id' => $notification->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
