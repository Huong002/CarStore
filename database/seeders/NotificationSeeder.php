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
                'content' => '<p>Chào bạn,&nbsp;</p><p>Chúc mừng bạn đã đăng ký thành công trên trang web của chúng tôi! Chúng tôi rất vui mừng chào đón bạn đến với cộng đồng của chúng tôi và hy vọng rằng bạn sẽ tìm thấy những gì bạn đang tìm kiếm trên trang web của chúng tôi.</p><p>Với tài khoản của bạn, bạn có thể truy cập đầy đủ các tính năng của trang web của chúng tôi, bao gồm cập nhật thông tin cá nhân, đặt hàng và nhiều hơn nữa.</p><p>Chúng tôi rất mong muốn hỗ trợ bạn trong quá trình sử dụng trang web của chúng tôi. Nếu bạn có bất kỳ câu hỏi hoặc yêu cầu nào, vui lòng liên hệ với chúng tôi bằng cách truy cập trang liên hệ của chúng tôi.</p><p>Cảm ơn bạn đã đăng ký tài khoản với chúng tôi. Chúc bạn có một trải nghiệm tuyệt vời trên trang web của chúng tôi!</p><p>Trân trọng.</p>',
                'type' => 'customer', 
            ],
            [
                'name' => 'Đơn hàng mới',
                'content' => 'Có một đơn hàng mới cần xử lý',
                'type' => 'employee', 
            ],
            [
                'name' => 'Báo cáo doanh thu',
                'content' => 'Báo cáo doanh thu tháng mới đã sẵn sàng',
                'type' => 'admin', 
            ],
            [
                'name' => 'Cập nhật hệ thống',
                'content' => 'Hệ thống vừa được cập nhật tính năng mới',
                'type' => 'all', 
            ],
        ];

        foreach ($notifications as $data) {
            Notification::create($data);
        }
    }
}
