<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'BMW',
                'slug' => Str::slug('BMW'),
                'image' => null,
                'isDeleted' => false,
                'promotion_details' =><<<HTML
              <div style="border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
    <ul style="font-size: 16px; line-height: 1.6;">
        <li>Ưu đãi <span style="color: red;">“Cực Khủng”</span> dành riêng cho dòng xe BMW</li>
        <li>Tặng <span style="color: blue;"><strong>Combo tiền mặt + Gói phụ kiện</strong></span> lên đến <span style="color: red;"><strong>300Tr</strong></span></li>
        <li>Chọn <strong style="color: red;">Biển Số Đẹp</strong> theo ý khách hàng</li>
        <li>Tặng <strong>Iphone 14 Promax</strong> <span style="color: blue;">(có điều kiện)</span></li>
        <li>Tặng 1 năm <strong>Bảo hiểm vật chất</strong> bao gồm mất cắp</li>
        <li>Tặng 2 <strong>Phiếu thay dầu</strong> và bảo dưỡng toàn bộ xe <span style="color: blue;">(có điều kiện)</span></li>
        <li>Hỗ trợ xử lý <strong>Hồ sơ nguồn thu, Hồ sơ dư nợ xấu</strong> trên CIC</li>
        <li><strong style="color: red;">Lái thử xe tại nhà miễn phí</strong>, giao xe tận nơi</li>
        <li>Kho xe <strong style="color: red;">Đủ màu, Sẵn xe, Giao xe ngay</strong></li>
        <li>Hỗ trợ <strong>Thu cũ đổi mới</strong>, Ký gửi xe giá cao</li>
        <li>Đăng ký biển số <strong>Hà Nội</strong> không cần <strong>Hộ Khẩu</strong>, Tránh số <strong style="color: red;">Xấu</strong></li>
        <li>Mua xe <strong style="color: red;">Trả góp 90% giá trị xe</strong>, lãi suất ưu đãi, thủ tục nhanh gọn</li>
        <li><strong style="color: red;">Hỗ trợ kỹ thuật 24/7</strong>, đặt lịch bảo dưỡng từ xa hoặc tận nhà</li>
    </ul>
</div>
HTML,
            ],
            [
                'name' => 'Porsche',
                'slug' => Str::slug('Porsche'),
                'image' => null,
                'isDeleted' => false,
                'promotion_details' =>null,
            ],
            [
                'name' => 'Audi',
                'slug' => Str::slug('Audi'),
                'image' => null,
                'isDeleted' => false,
                'promotion_details' =>null,
                
            ],
            [
                'name' => 'Chevrolet',
                'slug' => Str::slug('Chevrolet'),
                'image' => null,
                'isDeleted' => false,
                'promotion_details' =>null,
            ],
            [
                'name' => 'Mercedes-Benz',
                'slug' => Str::slug('Mercedes-Benz'),
                'image' => null,
                'isDeleted' => false,
                 'promotion_details' =><<<HTML
                <div>
     <ul style="font-size: 16px; line-height: 1.6;">
        <li>Giảm trực tiếp <strong style="color: red;">tới 200 triệu đồng</strong> khi thanh toán trong tháng</li>
        <li>Hỗ trợ <strong>đăng ký biển số toàn quốc</strong>, không cần hộ khẩu</li>
        <li>Miễn phí <strong>3 lần bảo dưỡng định kỳ</strong> đầu tiên</li>
        <li>Ưu đãi <strong>0% lãi suất</strong> trong 12 tháng đầu (theo gói tài chính liên kết)</li>
        <li>Nhận ngay <strong>gói bảo hiểm vật chất</strong> trị giá 1 năm</li>
        <li>Tặng <strong>camera hành trình chính hãng</strong> và <strong>thảm lót sàn 5D</strong></li>
        <li>Xe có sẵn <strong>giao ngay trong 24h</strong>đầy đủ màu sắc và phiên bản</li>
        <li>Hỗ trợ <strong>đổi xe cũ lên đời</strong> với định giá hấp dẫn</li>
        <li>Lái thử tận nhà <strong>đặt lịch chỉ với 1 cuộc gọi</strong></li>
        <li>Chương trình ưu đãi chỉ áp dụng trong <strong style="color: red;">tháng này</strong></li>
    </ul>
</div>
HTML,
            ],
            [
                'name' => 'Volkswagen',
                'slug' => Str::slug('Volkswagen'),
                'image' => null,
                'isDeleted' => false,
                'promotion_details' =>null,
            ],
            [
                'name' => 'Jaguar',
                'slug' => Str::slug('Jaguar'),
                'image' => null,
                'isDeleted' => false,
                 'promotion_details' =>null,
            ],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'image' => $brand['image'],
                'isDeleted' => $brand['isDeleted'],
                'promotion_details' => $brand['promotion_details'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}