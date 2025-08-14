@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary text-center">Câu Hỏi Thường Gặp (FAQ)</h1>

    {{-- Thông báo gửi câu hỏi thành công --}}
    @if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Đóng"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Thanh tìm kiếm + nút gửi câu hỏi -->
    <div class="mb-4 d-flex flex-wrap align-items-center gap-3">
        <div class="position-relative flex-grow-1" style="max-width: 400px;">
            <input type="text" id="faqSearch" class="form-control ps-5 py-2 rounded-pill shadow-sm border-light"
                placeholder="Tìm kiếm câu hỏi ở đây...">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
        </div>
        <button class="btn btn-primary rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="modal"
            data-bs-target="#askQuestionModal">
            <i class="bi bi-question-circle me-1"></i> Gửi câu hỏi
        </button>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs border-0 mb-3" id="faqTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold rounded-pill px-4 py-2 me-2" id="cuahang-tab"
                data-bs-toggle="tab" data-bs-target="#cuahang" type="button" role="tab" aria-controls="cuahang"
                aria-selected="true">
                CỬA HÀNG
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold rounded-pill px-4 py-2" id="sanpham-tab" data-bs-toggle="tab"
                data-bs-target="#sanpham" type="button" role="tab" aria-controls="sanpham" aria-selected="false">
                SẢN PHẨM
            </button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="faqTabContent">
        <!-- Tab Cửa Hàng -->
        <div class="tab-pane fade show active" id="cuahang" role="tabpanel" aria-labelledby="cuahang-tab">
            @if(isset($faqs['cuahang']) && count($faqs['cuahang']) > 0)
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
                    <div class="accordion" id="accordionCuahang">
                        @foreach($faqs['cuahang'] as $index => $faq)
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="headingCuahang{{ $index }}">
                                <button class="accordion-button collapsed bg-white fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseCuahang{{ $index }}"
                                    aria-expanded="false" aria-controls="collapseCuahang{{ $index }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapseCuahang{{ $index }}" class="accordion-collapse collapse"
                                aria-labelledby="headingCuahang{{ $index }}" data-bs-parent="#accordionCuahang">
                                <div class="accordion-body text-muted">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 d-flex align-items-start">
                    <div class="faq-image-container">
                        <img src="{{ asset('images/product-faq.jpg') }}" alt="FAQ Image"
                            class="img-fluid rounded shadow-sm w-100 h-100">
                    </div>
                </div>
            </div>
            @else
            <p class="text-muted">Không có câu hỏi nào cho cửa hàng.</p>
            @endif
        </div>

        <!-- Tab Sản Phẩm -->
        <div class="tab-pane fade" id="sanpham" role="tabpanel" aria-labelledby="sanpham-tab">
            @if(isset($faqs['sanpham']) && count($faqs['sanpham']) > 0)
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
                    <div class="accordion" id="accordionSanpham">
                        @foreach($faqs['sanpham'] as $index => $faq)
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="headingSanpham{{ $index }}">
                                <button class="accordion-button collapsed bg-white fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseSanpham{{ $index }}"
                                    aria-expanded="false" aria-controls="collapseSanpham{{ $index }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapseSanpham{{ $index }}" class="accordion-collapse collapse"
                                aria-labelledby="headingSanpham{{ $index }}" data-bs-parent="#accordionSanpham">
                                <div class="accordion-body text-muted">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 d-flex align-items-start">
                    <div class="faq-image-container">
                        <img src="{{ asset('images/product-faq.jpg') }}" alt="FAQ Image"
                            class="img-fluid rounded shadow-sm w-100 h-100">
                    </div>
                </div>
            </div>
            @else
            <p class="text-muted">Không có câu hỏi nào cho sản phẩm.</p>
            @endif
        </div>
    </div>
</div>


<!-- Modal gửi câu hỏi -->
<div class="modal fade" id="askQuestionModal" tabindex="-1" aria-labelledby="askQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('faq.storePending') }}" method="POST"
            class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            @csrf
            <!-- Header -->
            <div class="modal-header text-white py-2" style="background-color: #5bc0de;">
                <h5 class="modal-title d-flex align-items-center" id="askQuestionModalLabel">
                    <i class="bi bi-pencil-square me-2"></i> Gửi câu hỏi của bạn
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Đóng"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 bg-light">
                <div class="mb-3">
                    <label for="question" class="form-label fw-semibold">Câu hỏi của bạn</label>
                    <textarea name="question" id="question" rows="5" class="form-control shadow-sm border-0 rounded-3"
                        placeholder="Nhập câu hỏi của bạn ở đây..." required></textarea>
                </div>
                <small class="text-muted">Chúng tôi sẽ trả lời bạn sớm nhất có thể.</small>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light border-0 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Hủy
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-send-fill me-1"></i> Gửi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
/* Gradient header đẹp hơn */
.modal-header {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}

/* Body nhẹ nhàng, shadow cho textarea */
.modal-body .form-control {
    resize: none;
    min-height: 120px;
    background-color: #f8f9fa;
}

/* Hover button */
.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}

.btn-outline-secondary:hover {
    background-color: #e2e6ea;
}

/* Rounded đẹp hơn */
.modal-content {
    border-radius: 1rem;
}

/* Footer gọn và bóng */
.modal-footer button {
    transition: all 0.2s ease;
}
</style>

{{-- CSS tùy chỉnh --}}
<style>
/* Accordion dấu + / - */
.accordion-button::after {
    background-image: none !important;
    content: '+';
    font-size: 1.2rem;
    font-weight: bold;
    margin-left: auto;
    color: #6c757d;
    transition: transform 0.2s ease, color 0.2s ease;
}

.accordion-button:not(.collapsed)::after {
    content: '–';
    color: #0d6efd;
}

/* Accordion style */
.accordion-item {
    border: none;
    border-bottom: 1px solid #dee2e6;
    padding: 0.75rem 0;
}

.accordion-button {
    box-shadow: none !important;
    background-color: transparent;
}

.accordion-button:focus {
    outline: none;
    box-shadow: none;
}

/* Hình ảnh FAQ */
.faq-image-container {
    width: 100%;
    max-height: 400px;
    overflow: hidden;
}

.faq-image-container img {
    object-fit: cover;
    width: 100%;
    height: 100%;
}

/* Tabs */
.nav-tabs .nav-link {
    background-color: #f8f9fa;
    border: none;
    color: #6c757d;
    transition: all 0.2s ease;
}

.nav-tabs .nav-link.active {
    background-color: #0d6efd;
    color: white;
}

/* Placeholder tìm kiếm */
#faqSearch::placeholder {
    color: #adb5bd;
}
</style>

{{-- Script gộp tìm kiếm + toast --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tìm kiếm FAQ
    const faqSearch = document.getElementById('faqSearch');
    if (faqSearch) {
        faqSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.faq-item').forEach(item => {
                const question = item.querySelector('.accordion-button').textContent
                    .toLowerCase();
                item.style.display = question.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Toast tự ẩn
    const toastEl = document.getElementById('liveToast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
            delay: 5000
        });
        toast.show();
    }
});
</script>
@endsection