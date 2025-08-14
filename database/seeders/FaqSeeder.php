<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // FAQ cho sản phẩm
            [
                'category' => 'sanpham',
                'question' => 'Sản phẩm trưng bày tại showroom có giống với hình ảnh trên website không?',
                'answer' => 'Sản phẩm tại showroom là hàng thật, đảm bảo mẫu mã, kích thước và màu sắc gần giống hình ảnh trên website. Tuy nhiên, ánh sáng và góc chụp có thể khiến màu sắc hiển thị khác một chút.'
            ],
            [
                'category' => 'sanpham',
                'question' => 'Sản phẩm có phải là hàng mới 100% không?',
                'answer' => 'Tất cả sản phẩm đều là hàng mới, nguyên đai nguyên kiện. Một số sản phẩm trưng bày chỉ dùng để tham khảo và trải nghiệm trước khi mua.'
            ],
            [
                'category' => 'sanpham',
                'question' => 'Sản phẩm có được bảo hành không?',
                'answer' => 'Có. Thời gian bảo hành tùy thuộc vào từng loại sản phẩm và sẽ được ghi rõ trong phiếu bảo hành hoặc trên website.'
            ],
            [
                'category' => 'sanpham',
                'question' => 'Có thể đặt sản phẩm tùy chỉnh màu sắc hoặc kích thước không?',
                'answer' => 'Một số sản phẩm hỗ trợ tùy chỉnh theo yêu cầu. Vui lòng liên hệ nhân viên showroom để được tư vấn chi tiết.'
            ],
            [
                'category' => 'sanpham',
                'question' => 'Sản phẩm mua tại showroom có hỗ trợ đổi/trả không?',
                'answer' => 'Có, theo chính sách đổi trả của cửa hàng. Sản phẩm cần còn nguyên tình trạng, đầy đủ phụ kiện và hóa đơn mua hàng.'
            ],
            [
                'category' => 'sanpham',
                'question' => 'Sản phẩm có phiếu hướng dẫn sử dụng đi kèm không?',
                'answer' => 'Tất cả sản phẩm đều đi kèm hướng dẫn sử dụng chi tiết và thông tin bảo hành.'
            ],
            [
                'category' => 'sanpham',
                'question' => 'Có hỗ trợ kiểm tra sản phẩm trước khi mua không?',
                'answer' => 'Khách hàng có thể trực tiếp trải nghiệm sản phẩm tại showroom trước khi quyết định mua.'
            ],

            // FAQ cho cửa hàng
            [
                'category' => 'cuahang',
                'question' => 'Showroom mở cửa vào thời gian nào?',
                'answer' => 'Showroom mở cửa từ 8:00 – 21:00, tất cả các ngày trong tuần, bao gồm lễ và Tết.'
            ],
            [
                'category' => 'cuahang',
                'question' => 'Showroom có địa chỉ ở đâu?',
                'answer' => 'Địa chỉ: Cao Lãnh, Đồng Tháp. Bạn có thể xem bản đồ chỉ đường trên website hoặc Google Maps.'
            ],
            [
                'category' => 'cuahang',
                'question' => 'Có bãi đỗ xe cho khách hàng không?',
                'answer' => 'Có. Showroom có khu vực đỗ xe miễn phí cho ô tô và xe máy của khách.'
            ],
            [
                'category' => 'cuahang',
                'question' => 'Có cần đặt lịch hẹn trước khi đến showroom không?',
                'answer' => 'Không bắt buộc, nhưng nếu muốn được tư vấn chuyên sâu hoặc trải nghiệm sản phẩm đặc biệt, nên đặt lịch hẹn trước.'
            ],
            [
                'category' => 'cuahang',
                'question' => 'Showroom có dịch vụ giao hàng tận nơi không?',
                'answer' => 'Có, chúng tôi hỗ trợ giao hàng tận nơi trên toàn quốc. Phí vận chuyển tùy theo khu vực và chương trình khuyến mãi tại thời điểm mua hàng.'
            ],
            [
                'category' => 'cuahang',
                'question' => 'Showroom có phục vụ tư vấn trực tuyến không?',
                'answer' => 'Có. Bạn có thể liên hệ qua hotline hoặc chat trực tuyến trên website để được tư vấn trước khi đến showroom.'
            ],
            [
                'category' => 'cuahang',
                'question' => 'Có chương trình khuyến mãi hay ưu đãi định kỳ không?',
                'answer' => 'Showroom thường xuyên có các chương trình khuyến mãi. Thông tin sẽ được cập nhật trên website và fanpage chính thức.'
            ],
        ];

        Faq::insert($faqs);
    }
}