<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = Blog::where('status', 'published')->get();
        $users = User::all();

        $comments = [
            'Bài viết rất hữu ích, cảm ơn tác giả đã chia sẻ!',
            'Mình đang quan tâm đến mẫu xe này, thông tin rất chi tiết.',
            'Có thể chia sẻ thêm về giá cả không ạ?',
            'Đánh giá rất khách quan và chính xác.',
            'Mình đã thử theo hướng dẫn và thấy hiệu quả.',
            'Cần cập nhật thêm thông tin về phiên bản mới nhất.',
            'So sánh rất hay, giúp mình định hướng được lựa chọn.',
            'Hình ảnh minh họa rất đẹp và rõ ràng.',
            'Bài viết thiếu thông tin về chi phí vận hành.',
            'Rất mong có thêm những bài viết như thế này.'
        ];

        // $authorNames = [
        //     'Nguyễn Văn Minh',
        //     'Trần Thị Hoa',
        //     'Lê Hoàng Nam',
        //     'Phạm Thị Lan',
        //     'Hoàng Văn Đức',
        //     'Vũ Thị Mai',
        //     'Đặng Minh Tuấn',
        //     'Ngô Thị Linh',
        //     'Bùi Văn Hùng',
        //     'Đinh Thị Thu'
        // ];

        // $authorEmails = [
        //     'minh.nguyen@email.com',
        //     'hoa.tran@email.com',
        //     'nam.le@email.com',
        //     'lan.pham@email.com',
        //     'duc.hoang@email.com',
        //     'mai.vu@email.com',
        //     'tuan.dang@email.com',
        //     'linh.ngo@email.com',
        //     'hung.bui@email.com',
        //     'thu.dinh@email.com'
        // ];

        foreach ($blogs as $blog) {
            $numberOfComments = rand(2, 6);

            for ($i = 0; $i < $numberOfComments; $i++) {
                $randomUser = $users->random();
                
                BlogComment::create([
                    'blog_id' => $blog->id,
                    'author_name' => $randomUser->name,
                    'author_email' => $randomUser->email,
                    'content' => $comments[array_rand($comments)],
                    'user_id' => $randomUser->id,
                ]);
            }
        }
    }
}
