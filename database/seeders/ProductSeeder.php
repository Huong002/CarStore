<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'BMW M5 Sedan 2010',
                'slug' => Str::slug('BMW 2 Series 2023'),
                'short_description' => 'Coupe thể thao nhỏ gọn, mạnh mẽ',
                'description' => 'BMW 2 Series 2023 là mẫu coupe thể thao với thiết kế năng động, nội thất sang trọng. Xe được trang bị động cơ 2.0L TwinPower Turbo, công suất 255 mã lực, hộp số tự động 8 cấp Steptronic. Hệ thống lái nhạy, hệ thống treo thích ứng M Sport, cùng các công nghệ hiện đại như màn hình cảm ứng 10.25 inch, hỗ trợ Apple CarPlay/Android Auto, và gói an toàn Active Guard Plus.',
                'regular_price' => 1500000000, // 1.5 tỷ
                'sale_price' => 1450000000,   // 1.45 tỷ
                'SKU' => 'BMW2S2023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 10,
                'category_id' => 1, // Xe coupe
                'brand_id' => 1, // BMW
            ],
            [
                'name' => 'BMW 4 Series 2023',
                'slug' => Str::slug('BMW 4 Series 2023'),
                'short_description' => 'Coupe sang trọng với thiết kế táo bạo',
                'description' => 'BMW 4 Series 2023 nổi bật với lưới tản nhiệt cỡ lớn đặc trưng, động cơ 2.0L TwinPower Turbo sản sinh 258 mã lực, kết hợp hộp số tự động 8 cấp. Nội thất bọc da Vernasca, hệ thống giải trí iDrive 7.0, màn hình 12.3 inch. Xe tích hợp các tính năng an toàn như cảnh báo va chạm, hỗ trợ giữ làn, và đỗ xe tự động.',
                'regular_price' => 2000000000, // 2 tỷ
                'sale_price' => 1900000000,   // 1.9 tỷ
                'SKU' => 'BMW4S2023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 8,
                'category_id' => 1, // Xe coupe
                'brand_id' => 1, // BMW
            ],
            [
                'name' => 'BMW iX3 2023',
                'slug' => Str::slug('BMW iX3 2023'),
                'short_description' => 'SUV điện cao cấp, thân thiện môi trường',
                'description' => 'BMW iX3 2023 là mẫu SUV chạy điện với động cơ điện 286 mã lực, pin 80 kWh, phạm vi hoạt động khoảng 460 km (WLTP). Xe sở hữu thiết kế hiện đại, nội thất bọc da Sensatec, màn hình kép 12.3 inch, và hệ thống hỗ trợ lái xe tiên tiến như Driving Assistant Professional. Tăng tốc 0-100 km/h trong 6.8 giây.',
                'regular_price' => 2500000000, // 2.5 tỷ
                'sale_price' => 2400000000,   // 2.4 tỷ
                'SKU' => 'BMWiX32023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 5,
                'category_id' => 3, // Xe điện
                'brand_id' => 1, // BMW
            ],
            [
                'name' => 'BMW X1 2023',
                'slug' => Str::slug('BMW X1 2023'),
                'short_description' => 'SUV compact cao cấp, linh hoạt',
                'description' => 'BMW X1 2023 là mẫu SUV nhỏ gọn với động cơ 2.0L TwinPower Turbo, công suất 204 mã lực, hộp số ly hợp kép 7 cấp. Thiết kế ngoại thất mạnh mẽ, nội thất hiện đại với màn hình cong BMW Curved Display, hệ điều hành iDrive 8. Hệ thống an toàn bao gồm hỗ trợ đỗ xe, cảnh báo điểm mù, và camera 360 độ.',
                'regular_price' => 1800000000, // 1.8 tỷ
                'sale_price' => 1750000000,   // 1.75 tỷ
                'SKU' => 'BMWX12023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 12,
                'category_id' => 2, // Xe SUV
                'brand_id' => 1, // BMW
            ],
            [
                'name' => 'BMW X5 2023',
                'slug' => Str::slug('BMW X5 2023'),
                'short_description' => 'SUV cỡ lớn sang trọng, mạnh mẽ',
                'description' => 'BMW X5 2023 mang đến trải nghiệm lái đỉnh cao với động cơ 3.0L TwinPower Turbo, công suất 340 mã lực, hộp số tự động 8 cấp. Nội thất xa xỉ với da Merino, hệ thống âm thanh Harman Kardon, và màn hình 12.3 inch. Xe được trang bị hệ dẫn động 4 bánh xDrive, hỗ trợ off-road và các tính năng an toàn tiên tiến.',
                'regular_price' => 3500000000, // 3.5 tỷ
                'sale_price' => 3400000000,   // 3.4 tỷ
                'SKU' => 'BMWX52023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 6,
                'category_id' => 2, // Xe SUV
                'brand_id' => 1, // BMW
            ],
            [
                'name' => 'Porsche 911 Club Coupe 60th Anniversary',
                'slug' => Str::slug('Porsche 911 Club Coupe 60th Anniversary'),
                'short_description' => 'Siêu xe kỷ niệm, phiên bản giới hạn',
                'description' => 'Porsche 911 Club Coupe 60th Anniversary là phiên bản đặc biệt kỷ niệm 60 năm, với động cơ 3.0L 6 xy-lanh, công suất 480 mã lực, hộp số PDK 7 cấp. Thiết kế ngoại thất độc đáo với màu sơn đặc biệt, nội thất bọc da Alcantara, hệ thống giải trí PCM 6.0, và các chi tiết tùy chỉnh thủ công.',
                'regular_price' => 6000000000, // 6 tỷ
                'sale_price' => 5800000000,   // 5.8 tỷ
                'SKU' => 'P911CC2023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 3,
                'category_id' => 4, // Xe thể thao
                'brand_id' => 2, // Porsche
            ],
            [

                'name' => 'Porsche 911 Turbo S Cabriolet 2023',
                'slug' => Str::slug('Porsche 911 Turbo S Cabriolet 2023'),
                'short_description' => 'Siêu xe mui trần hiệu suất cao',
                'description' => 'Porsche 911 Turbo S Cabriolet 2023 sở hữu động cơ 3.8L 6 xy-lanh, công suất 650 mã lực, tăng tốc 0-100 km/h trong 2.8 giây. Hộp số PDK 8 cấp, hệ dẫn động 4 bánh. Nội thất bọc da cao cấp, màn hình 10.9 inch, hệ thống âm thanh Burmester, và gói an toàn Porsche Active Safe.',
                'regular_price' => 6500000000, // 6.5 tỷ
                'sale_price' => 6300000000,   // 6.3 tỷ
                'SKU' => 'P911TS2023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 4,
                'category_id' => 5, // Xe convertible
                'brand_id' => 2, // Porsche
            ],
            [
                'name' => 'Porsche 911 GT3 Touring 2022',
                'slug' => Str::slug('Porsche 911 GT3 Touring 2022'),
                'short_description' => 'Siêu xe GT3 với thiết kế tinh tế',
                'description' => 'Porsche 911 GT3 Touring 2022 sử dụng động cơ 4.0L 6 xy-lanh, công suất 502 mã lực, hộp số PDK 7 cấp hoặc số sàn 6 cấp. Xe có thiết kế thanh lịch, không cánh gió lớn, nội thất bọc da cao cấp, hệ thống treo thể thao PASM, và các tính năng hỗ trợ lái như Porsche Torque Vectoring.',
                'regular_price' => 5500000000, // 5.5 tỷ
                'sale_price' => 5300000000,   // 5.3 tỷ
                'SKU' => 'P911GT32022001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 5,
                'category_id' => 4, // Xe thể thao
                'brand_id' => 2, // Porsche
            ],
            [
                'name' => 'Porsche 996 Carrera 4S 2004',
                'slug' => Str::slug('Porsche 996 Carrera 4S 2004'),
                'short_description' => 'Siêu xe cổ điển, hiệu suất vượt thời gian',
                'description' => 'Porsche 996 Carrera 4S 2004 là mẫu xe mang tính biểu tượng với động cơ 3.6L 6 xy-lanh, công suất 320 mã lực, hệ dẫn động 4 bánh. Nội thất bọc da cổ điển, hệ thống âm thanh Bose, và thiết kế ngoại thất mang phong cách thập niên 2000. Xe vẫn giữ được sự mạnh mẽ và phong cách đặc trưng của Porsche.',
                'regular_price' => 3000000000, // 3 tỷ
                'sale_price' => 2800000000,   // 2.8 tỷ
                'SKU' => 'P996C4S2004001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 7,
                'category_id' => 4, // Xe thể thao
                'brand_id' => 2, // Porsche
            ],
            [
                'name' => 'Porsche Macan 2023',
                'slug' => Str::slug('Porsche Macan 2023'),
                'short_description' => 'SUV thể thao sang trọng',
                'description' => 'Porsche Macan 2023 kết hợp phong cách SUV với hiệu suất thể thao, sử dụng động cơ 2.0L Turbo, công suất 265 mã lực, hộp số PDK 7 cấp. Nội thất bọc da cao cấp, màn hình 10.9 inch, hệ thống âm thanh Bose. Xe trang bị hệ dẫn động 4 bánh và các tính năng an toàn như cảnh báo lệch làn, hỗ trợ đỗ xe.',
                'regular_price' => 3200000000, // 3.2 tỷ
                'sale_price' => 3100000000,   // 3.1 tỷ
                'SKU' => 'PMAC2023001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 10,
                'category_id' => 2, // Xe SUV
                'brand_id' => 2, // Porsche
            ],
            [
                'name' => 'Porsche Turbo GT 2022',
                'slug' => Str::slug('Porsche Turbo GT 2022'),
                'short_description' => 'Siêu xe hiệu suất đỉnh cao',
                'description' => 'Porsche Turbo GT 2022 là phiên bản mạnh mẽ với động cơ 4.0L V8, công suất 640 mã lực, tăng tốc 0-100 km/h trong 3.0 giây. Hộp số PDK 8 cấp, hệ dẫn động 4 bánh. Nội thất thể thao với ghế đua carbon, hệ thống giải trí PCM 6.0, và các tính năng an toàn như Porsche Ceramic Composite Brakes (PCCB).',
                'regular_price' => 7000000000, // 7 tỷ
                'sale_price' => 6800000000,   // 6.8 tỷ
                'SKU' => 'PTGT2022001',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 3,
                'category_id' => 4, // Xe thể thao
                'brand_id' => 2, // Porsche
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
