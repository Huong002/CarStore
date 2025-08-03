@extends('layouts.app')
@section('content')

<main class="pt-90">

    <!-- BANNER FULL WIDTH -->
    <section style="margin:0; padding:0;">
        <div style="width:100%;">
            <img src="/assets/images/about/showroom.jpg" alt="Showroom ô tô"
                style="width:100%; height:550px; object-fit:cover; display:block;">
        </div>
    </section>

    <!-- Tiêu đề nằm dưới ảnh -->
    <section class="container text-center py-5">
        <h1 class="fw-bold display-4 mb-3">Về Chúng Tôi</h1>
        <p class="fs-5 mb-0" style="color:#7B1E1E;">
            Đối tác đáng tin cậy – Đồng hành cùng bạn trên mọi hành trình
        </p>



    </section>


    <!-- 3 CỘT GIỚI THIỆU -->
    <section class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <h2 class="fw-bold" style="color:#5E83AE;">10+ Năm</h2>
                <p class="text-muted">Kinh nghiệm phân phối và dịch vụ ô tô chính hãng</p>
            </div>
            <div class="col-md-4 mb-4">
                <h2 class="fw-bold" style="color:#5E83AE;">100%</h2>
                <p class="text-muted">Sản phẩm chính hãng, minh bạch bảo hành</p>
            </div>
            <div class="col-md-4 mb-4">
                <h2 class="fw-bold" style="color:#5E83AE;">5000+</h2>
                <p class="text-muted">Khách hàng tin tưởng đồng hành mỗi năm</p>
            </div>
        </div>
    </section>


    <!-- CÂU CHUYỆN -->
    <section class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <img src="/assets/images/about/showroom1.jpg" class="w-100 rounded shadow"
                    style="object-fit:cover; max-height:400px;" alt="Showroom bên trong">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Câu Chuyện Của Chúng Tôi</h2>
                <p class="mb-3">
                    Khởi nguồn từ niềm đam mê với xe hơi, chúng tôi đã phát triển từ một showroom nhỏ thành hệ thống
                    phân phối uy tín,
                    mang đến những mẫu xe chất lượng từ các thương hiệu hàng đầu thế giới.
                </p>
                <p class="mb-4">
                    Với triết lý “Khách hàng là trung tâm”, chúng tôi luôn đồng hành cùng bạn từ khâu tư vấn, lựa chọn
                    xe cho đến dịch vụ hậu mãi.
                </p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Sứ Mệnh</h5>
                        <p>Cung cấp giải pháp di chuyển hiện đại, an toàn và đẳng cấp.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Tầm Nhìn</h5>
                        <p>Trở thành thương hiệu hàng đầu về phân phối và dịch vụ ô tô tại Việt Nam.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LÝ DO CHỌN -->
    <section class="container py-5">
        <h2 class="text-center fw-bold mb-5">Tại Sao Chọn Chúng Tôi?</h2>
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <img src="/assets/images/icons/service.png" width="60" class="mb-3" alt="">
                <h5 class="fw-bold">Dịch vụ tận tâm</h5>
                <p class="text-muted">Đội ngũ hỗ trợ tận tình, chuyên nghiệp và chu đáo.</p>
            </div>
            <div class="col-md-3 mb-4">
                <img src="/assets/images/icons/quality.png" width="60" class="mb-3" alt="">
                <h5 class="fw-bold">Chính hãng 100%</h5>
                <p class="text-muted">Xe nhập khẩu và phân phối chính hãng, bảo hành đầy đủ.</p>
            </div>
            <div class="col-md-3 mb-4">
                <img src="/assets/images/icons/finance.png" width="60" class="mb-3" alt="">
                <h5 class="fw-bold">Hỗ trợ tài chính</h5>
                <p class="text-muted">Tư vấn vay vốn và trả góp linh hoạt theo nhu cầu.</p>
            </div>
            <div class="col-md-3 mb-4">
                <img src="/assets/images/icons/after-sale.png" width="60" class="mb-3" alt="">
                <h5 class="fw-bold">Hậu mãi chuyên nghiệp</h5>
                <p class="text-muted">Bảo dưỡng, bảo trì tận tâm và đồng hành lâu dài.</p>
            </div>
        </div>
    </section>

    <!-- KÊU GỌI -->
    <section class="container py-5 text-center">
        <h2 class="fw-bold mb-3">Sẵn Sàng Chọn Chiếc Xe Mơ Ước?</h2>
        <p class="mb-0 text-muted">
            Liên hệ ngay hôm nay để được tư vấn dòng xe phù hợp nhất và nhận ưu đãi đặc biệt.
        </p>
    </section>

</main>

@endsection