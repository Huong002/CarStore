<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;

class SyncUserNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync existing notifications with user_notifications table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu đồng bộ thông báo...');

        // Lấy tất cả thông báo chưa bị xóa
        $notifications = Notification::whereNull('deleted_at')->get();

        $created = 0;

        foreach ($notifications as $notification) {
            $userIds = [];

            // Xác định user cần nhận thông báo dựa vào type
            if ($notification->type === 'all') {
                $userIds = User::pluck('id')->toArray();
            } elseif ($notification->type === 'admin') {
                $userIds = User::where('utype', 'ADM')->pluck('id')->toArray();
            } elseif ($notification->type === 'employee') {
                $userIds = User::where('utype', 'EMP')->pluck('id')->toArray();
            } elseif ($notification->type === 'customer') {
                $userIds = User::where('utype', 'CTM')->pluck('id')->toArray();
            }

            // Tạo UserNotification cho mỗi user nếu chưa tồn tại
            foreach ($userIds as $userId) {
                $exists = UserNotification::where('user_id', $userId)
                    ->where('notification_id', $notification->id)
                    ->exists();

                if (!$exists) {
                    UserNotification::create([
                        'user_id' => $userId,
                        'notification_id' => $notification->id,
                        'isRead' => false,
                        'isArchived' => false
                    ]);
                    $created++;
                }
            }
        }

        $this->info("Đã tạo {$created} user notifications mới.");
        $this->info('Hoàn thành đồng bộ!');

        return 0;
    }
}
