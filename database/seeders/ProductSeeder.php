<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'BMW M5 Sedan 2010',
                'slug' => Str::slug('BMW M5 Sedan 2010'),
                'short_description' => 'Sedan thể thao sang trọng với hiệu suất mạnh mẽ.',
                'description' => 'BMW M5 Sedan 2010 là mẫu sedan hiệu suất cao thuộc dòng 5 Series, được trang bị động cơ V10 5.0L, sản sinh công suất 500 mã lực và mô-men xoắn 520 Nm. Xe sở hữu hộp số tự động SMG 7 cấp hoặc số sàn 6 cấp, cho khả năng tăng tốc từ 0-100 km/h trong 4,7 giây. Nội thất bọc da cao cấp, hệ thống giải trí iDrive hiện đại và thiết kế ngoại thất đậm chất thể thao với lưới tản nhiệt đặc trưng và bộ mâm hợp kim 19 inch. Đây là lựa chọn lý tưởng cho những ai yêu thích sự kết hợp giữa sang trọng và tốc độ.',
                'regular_price' => 1200000000,
                'sale_price' => 1100000000,
                'SKU' => 'BMW-M5-2010',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 5,
                'category_id' => 1, // Sedan
                'brand_id' => 1, // BMW
                'color_id' => 4,
            ],
            [
                'name' => 'BMW ActiveHybrid 5 Sedan 2012',
                'slug' => Str::slug('BMW ActiveHybrid 5 Sedan 2012'),
                'short_description' => 'Sedan hybrid tiết kiệm nhiên liệu, hiệu suất cao.',
                'description' => 'BMW ActiveHybrid 5 Sedan 2012 là mẫu xe hybrid đầu tiên trong dòng 5 Series, kết hợp động cơ xăng I6 3.0L tăng áp kép (TwinPower Turbo) với mô-tơ điện, tạo ra tổng công suất 335 mã lực và mô-men xoắn 450 Nm. Xe sử dụng hộp số tự động 8 cấp, cho phép tăng tốc từ 0-100 km/h trong 5,7 giây, đồng thời đạt mức tiêu hao nhiên liệu ấn tượng khoảng 6,4 lít/100 km. Nội thất sang trọng với ghế da Dakota, hệ thống iDrive cải tiến và màn hình 10,2 inch. Thiết kế ngoại thất tinh tế với các chi tiết mạ chrome và mâm hợp kim 18 inch, mang lại vẻ ngoài hiện đại và đẳng cấp.',
                'regular_price' => 1400000000,
                'sale_price' => 1300000000,
                'SKU' => 'BMW-AH5-2012',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 8,
                'category_id' => 1, // Sedan
                'brand_id' => 1, // BMW
                'color_id' => 4,

            ],
            [
                'name' => 'Audi TT RS Coupe 2012',
                'slug' => Str::slug('Audi TT RS Coupe 2012'),
                'short_description' => 'Coupe thể thao với thiết kế trẻ trung, mạnh mẽ.',
                'description' => 'Audi TT RS Coupe 2012 là phiên bản hiệu suất cao của dòng TT, được trang bị động cơ 5 xy-lanh 2.5L tăng áp, sản sinh công suất 360 mã lực và mô-men xoắn 465 Nm. Xe có khả năng tăng tốc từ 0-100 km/h trong 4,1 giây nhờ hệ dẫn động bốn bánh Quattro và hộp số ly hợp kép S-tronic 7 cấp. Thiết kế ngoại thất nổi bật với lưới tản nhiệt Singleframe, cản trước thể thao và mâm hợp kim 19 inch. Nội thất bọc da Alcantara, ghế thể thao ôm sát và hệ thống âm thanh Bose cao cấp, mang lại trải nghiệm lái xe đầy phấn khích.',
                'regular_price' => 2000000000,
                'sale_price' => 1900000000,
                'SKU' => 'AUDI-TTRS-2012',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 3,
                'category_id' => 3, // Coupe
                'brand_id' => 3, // Audi
                'color_id' => 4,            ],
            [
                'name' => 'BMW X3 SUV 2012',
                'slug' => Str::slug('BMW X3 SUV 2012'),
                'short_description' => 'SUV cao cấp, đa dụng và mạnh mẽ.',
                'description' => 'BMW X3 SUV 2012 thuộc thế hệ thứ hai (F25), được trang bị động cơ xăng hoặc diesel, với tùy chọn nổi bật là động cơ I6 3.0L tăng áp (xDrive35i) sản sinh 306 mã lực và mô-men xoắn 400 Nm. Xe sử dụng hộp số tự động 8 cấp và hệ dẫn động bốn bánh xDrive, cho khả năng tăng tốc từ 0-100 km/h trong 5,7 giây. Nội thất rộng rãi với ghế da Nevada, hệ thống iDrive với màn hình 8,8 inch và các tính năng an toàn như kiểm soát ổn định động lực học (DSC). Thiết kế ngoại thất hiện đại với lưới tản nhiệt lớn và mâm hợp kim 18-19 inch, phù hợp cho cả đô thị và địa hình nhẹ.',
                'regular_price' => 2000000000,
                'sale_price' => 1900000000,
                'SKU' => 'BMW-X3-2012',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 10,
                'category_id' => 2, // SUV
                'brand_id' => 1, // BMW
                'color_id' => 5,
            ],
            [
                'name' => 'BMW 3 Series Wagon 2012',
                'slug' => Str::slug('BMW 3 Series Wagon 2012'),
                'short_description' => 'Wagon thực dụng, phong cách thể thao.',
                'description' => 'BMW 3 Series Wagon 2012 (F31) là mẫu xe wagon thuộc dòng 3 Series, kết hợp không gian chở hàng rộng rãi với hiệu suất lái đặc trưng của BMW. Xe được trang bị động cơ I4 2.0L tăng áp (328i) sản sinh 240 mã lực và mô-men xoắn 350 Nm, đi kèm hộp số tự động 8 cấp hoặc số sàn 6 cấp. Hệ dẫn động cầu sau hoặc xDrive giúp xe tăng tốc từ 0-100 km/h trong khoảng 6 giây. Nội thất sang trọng với ghế da, hệ thống iDrive và khoang hành lý linh hoạt (lên đến 1.500L khi gập ghế). Thiết kế ngoại thất năng động với mâm hợp kim 17 inch và lưới tản nhiệt đặc trưng.',
                'regular_price' => 1900000000,
                'sale_price' => 1800000000,
                'SKU' => 'BMW-3W-2012',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 6,
                'category_id' => 6, // Wagon
                'brand_id' => 1, // BMW
                'color_id' => 11,
            ],
            [
                'name' => 'BMW X6 SUV 2012',
                'slug' => Str::slug('BMW X6 SUV 2012'),
                'short_description' => 'SUV coupe thời thượng, hiệu suất cao.',
                'description' => 'BMW X6 SUV 2012 (E71) là mẫu SUV coupe độc đáo, kết hợp thiết kế thể thao với tính năng đa dụng. Xe được trang bị động cơ I6 3.0L tăng áp (xDrive35i) hoặc V8 4.4L tăng áp (xDrive50i), sản sinh công suất lên đến 400 mã lực. Hệ dẫn động bốn bánh xDrive và hộp số tự động 8 cấp mang lại khả năng tăng tốc 0-100 km/h trong 5,4 giây (xDrive50i). Nội thất sang trọng với ghế da cao cấp, hệ thống iDrive và màn hình 10,2 inch. Thiết kế ngoại thất nổi bật với mái dốc kiểu coupe, lưới tản nhiệt lớn và mâm hợp kim 19-20 inch, tạo nên vẻ ngoài mạnh mẽ và khác biệt.',
                'regular_price' => 3200000000,
                'sale_price' => 3100000000,
                'SKU' => 'BMW-X6-2012',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 4,
                'category_id' => 2, // SUV
                'brand_id' => 1, // BMW
                'color_id' => 5,
            ],
            [
                'name' => 'Porsche Panamera Sedan 2012',
                'slug' => Str::slug('Porsche Panamera Sedan 2012'),
                'short_description' => 'Sedan sang trọng với hiệu suất thể thao.',
                'description' => 'Porsche Panamera Sedan 2012 là mẫu sedan 4 cửa kết hợp phong cách thể thao với sự sang trọng. Xe có nhiều tùy chọn động cơ, nổi bật là phiên bản Panamera Turbo với động cơ V8 4.8L tăng áp, sản sinh 500 mã lực và mô-men xoắn 700 Nm, tăng tốc từ 0-100 km/h trong 4,2 giây. Hệ dẫn động bốn bánh và hộp số PDK 7 cấp mang lại trải nghiệm lái mượt mà và mạnh mẽ. Nội thất bọc da cao cấp, hệ thống giải trí PCM với màn hình 7 inch và ghế thể thao điều chỉnh 14 hướng. Thiết kế ngoại thất đậm chất Porsche với đèn LED và mâm hợp kim 19 inch.',
                'regular_price' => 2500000000,
                'sale_price' => 0,
                'SKU' => 'POR-PAN-2012',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 7,
                'category_id' => 1, // Sedan
                'brand_id' => 2, // Porsche
                'color_id' => 4,
            ],
            [
                'name' => 'Chevrolet Corvette ZR1 2012',
                'slug' => Str::slug('Chevrolet Corvette ZR1 2012'),
                'short_description' => 'Siêu xe Mỹ với hiệu suất đỉnh cao.',
                'description' => 'Chevrolet Corvette ZR1 2012 là mẫu siêu xe hiệu suất cao, được trang bị động cơ V8 6.2L siêu nạp, sản sinh công suất 638 mã lực và mô-men xoắn 819 Nm. Xe sử dụng hộp số sàn 6 cấp, cho khả năng tăng tốc từ 0-100 km/h trong 3,4 giây và tốc độ tối đa hơn 330 km/h. Hệ thống treo Magnetic Ride Control và phanh gốm carbon đảm bảo hiệu suất vượt trội trên đường đua. Nội thất bọc da cao cấp, ghế thể thao và hệ thống âm thanh Bose. Thiết kế ngoại thất khí động học với cánh lướt gió carbon và mâm hợp kim 19-20 inch.',
                'regular_price' => 2500000000,
                'sale_price' => 2300000000,
                'SKU' => 'CHEV-ZR1-2012',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 2,
                'category_id' => 3, // Coupe
                'brand_id' => 4, // Chevrolet
                'color_id' => 11,
            ],
            [
                'name' => 'Chevrolet Corvette Convertible 2012',
                'slug' => Str::slug('Chevrolet Corvette Convertible 2012'),
                'short_description' => 'Siêu xe mui trần mạnh mẽ, phong cách.',
                'description' => 'Chevrolet Corvette Convertible 2012 mang đến trải nghiệm lái xe mui trần đầy phấn khích, được trang bị động cơ V8 6.2L, sản sinh công suất 430 mã lực (phiên bản cơ bản) hoặc 505 mã lực (Grand Sport). Hộp số sàn 6 cấp hoặc tự động 6 cấp giúp xe tăng tốc từ 0-100 km/h trong khoảng 4,2 giây. Nội thất bọc da cao cấp, ghế thể thao và hệ thống giải trí với màn hình cảm ứng. Mái xếp mềm vận hành bằng điện, kết hợp với thiết kế ngoại thất khí động học và mâm hợp kim 18-19 inch, tạo nên vẻ ngoài mạnh mẽ và quyến rũ.',
                'regular_price' => 4000000000,
                'sale_price' => 380000000,
                'SKU' => 'CHEV-CV-2012',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 5,
                'category_id' => 4, // Convertible
                'brand_id' => 4, // Chevrolet
                'color_id' => 5,
            ],
            [
                'name' => 'Mercedes-Benz SL-Class Coupe 2009',
                'slug' => Str::slug('Mercedes-Benz SL-Class Coupe 2009'),
                'short_description' => 'Coupe mui cứng sang trọng, hiệu suất cao.',
                'description' => 'Mercedes-Benz SL-Class Coupe 2009 (R230) là mẫu xe mui cứng có thể thu vào, kết hợp sự sang trọng với hiệu suất thể thao. Phiên bản SL550 được trang bị động cơ V8 5.5L, sản sinh 382 mã lực và mô-men xoắn 530 Nm, tăng tốc từ 0-100 km/h trong 5,4 giây. Hộp số tự động 7 cấp và hệ thống treo Active Body Control mang lại sự êm ái và ổn định. Nội thất bọc da cao cấp, ghế massage tích hợp và hệ thống COMAND với màn hình 6,5 inch. Thiết kế ngoại thất thanh lịch với lưới tản nhiệt lớn và mâm hợp kim 18 inch.',
                'regular_price' => 3000000000,
                'sale_price' => 2800000000,
                'SKU' => 'MB-SL-2009',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 3,
                'category_id' => 3, // Coupe
                'brand_id' => 5, // Mercedes-Benz
                'color_id' => 4,
            ],
            [
                'name' => 'Volkswagen Beetle Hatchback 2012',
                'slug' => Str::slug('Volkswagen Beetle Hatchback 2012'),
                'short_description' => 'Hatchback phong cách retro, trẻ trung.',
                'description' => 'Volkswagen Beetle Hatchback 2012 là thế hệ thứ hai của mẫu xe mang phong cách retro, được trang bị động cơ I4 2.0L tăng áp (phiên bản Turbo) sản sinh 200 mã lực và mô-men xoắn 280 Nm, tăng tốc từ 0-100 km/h trong 7,5 giây. Hộp số DSG 6 cấp hoặc số sàn 6 cấp mang lại trải nghiệm lái năng động. Nội thất hiện đại với ghế bọc da hoặc vải, hệ thống giải trí Fender cao cấp và màn hình cảm ứng 5 inch. Thiết kế ngoại thất đặc trưng với hình dáng tròn trịa, đèn pha tròn và mâm hợp kim 17-18 inch.',
                'regular_price' => 2800000000,
                'sale_price' => 2700000000,
                'SKU' => 'VW-BEETLE-2012',
                'stock_status' => 'instock',
                'featured' => false,
                'quantity' => 12,
                'category_id' => 5, // Hatchback
                'brand_id' => 6, // Volkswagen
                'color_id' => 11,
            ],
            [
                'name' => 'Jaguar XK XKR 2012',
                'slug' => Str::slug('Jaguar XK XKR 2012'),
                'short_description' => 'Grand tourer sang trọng, mạnh mẽ.',
                'description' => 'Jaguar XK XKR 2012 là mẫu grand tourer cao cấp, được trang bị động cơ V8 5.0L siêu nạp, sản sinh 510 mã lực và mô-men xoắn 625 Nm, tăng tốc từ 0-100 km/h trong 4,6 giây. Hộp số tự động 6 cấp và hệ thống treo thích ứng mang lại sự cân bằng giữa hiệu suất và sự thoải mái. Nội thất bọc da cao cấp, ghế thể thao điều chỉnh 16 hướng và hệ thống giải trí với màn hình cảm ứng 7 inch. Thiết kế ngoại thất thanh lịch với lưới tản nhiệt lớn, đèn LED và mâm hợp kim 19-20 inch, toát lên vẻ sang trọng và mạnh mẽ.',
                'regular_price' => 2600000000,
                'sale_price' => 2500000000,
                'SKU' => 'JAG-XKR-2012',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 4,
                'category_id' => 3, // Coupe
                'brand_id' => 7, // Jaguar
                'color_id' => 4,
            ],
            [
                'name' => 'Porsche 911 Turbo S 2022',
                'slug' => Str::slug('Porsche 911 Turbo S 2022'),
                'short_description' => 'Siêu xe thể thao với hiệu suất đỉnh cao.',
                'description' => 'Porsche 911 Turbo S 2022 (992) là phiên bản đỉnh cao của dòng 911, được trang bị động cơ 6 xy-lanh phẳng 3.8L tăng áp kép, sản sinh 640 mã lực và mô-men xoắn 800 Nm. Xe tăng tốc từ 0-100 km/h trong 2,7 giây và đạt tốc độ tối đa 330 km/h. Hệ dẫn động bốn bánh và hộp số PDK 8 cấp mang lại khả năng vận hành linh hoạt. Nội thất bọc da cao cấp, ghế thể thao 18 hướng và hệ thống PCM với màn hình 10,9 inch. Thiết kế ngoại thất khí động học với cánh gió sau điều chỉnh và mâm hợp kim 20-21 inch.',
                'regular_price' => 2800000000,
                'sale_price' => 2600000000,
                'SKU' => 'POR-911TS-2022',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 2,
                'category_id' => 3, // Coupe
                'brand_id' => 2, // Porsche
                'color_id' => 5,
            ],
            [
                'name' => 'Porsche Macan 2020',
                'slug' => Str::slug('Porsche Macan 2020'),
                'short_description' => 'SUV compact sang trọng, thể thao.',
                'description' => 'Porsche Macan 2020 là mẫu SUV compact cao cấp, được trang bị động cơ I4 2.0L tăng áp (phiên bản cơ bản) sản sinh 248 mã lực và mô-men xoắn 370 Nm, tăng tốc từ 0-100 km/h trong 6,7 giây. Hộp số PDK 7 cấp và hệ dẫn động bốn bánh mang lại trải nghiệm lái năng động. Nội thất bọc da, ghế thể thao và hệ thống PCM với màn hình cảm ứng 10,9 inch. Thiết kế ngoại thất đặc trưng với đèn LED, lưới tản nhiệt lớn và mâm hợp kim 18-21 inch, tạo nên vẻ ngoài mạnh mẽ và tinh tế, phù hợp cho cả đô thị và đường trường.',
                'regular_price' => 2900000000,
                'sale_price' => 2800000000,
                'SKU' => 'POR-MACAN-2020',
                'stock_status' => 'instock',
                'featured' => true,
                'quantity' => 6,
                'category_id' => 2, // SUV
                'brand_id' => 2, // Porsche
                'color_id' => 5,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'short_description' => $product['short_description'],
                'description' => $product['description'],
                'regular_price' => $product['regular_price'],
                'sale_price' => $product['sale_price'],
                'SKU' => $product['SKU'],
                'stock_status' => $product['stock_status'],
                'featured' => $product['featured'],
                'quantity' => $product['quantity'],
                'category_id' => $product['category_id'],
                'brand_id' => $product['brand_id'],
                'color_id' => $product['color_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}