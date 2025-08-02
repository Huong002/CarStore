@extends('layouts.app')
@section('content')

<style>
/* Mặc định trái tim xám */
.js-add-wishlist svg {
    color: #666;
    cursor: pointer;
    transition: color 0.2s ease;
}

/* Khi được click */
.js-add-wishlist.icon-heart-active svg {
    color: red !important;
}

.add-to-wishlist svg {
    fill: #666;
    /* màu xám mặc định */
    cursor: pointer;
    transition: fill 0.3s ease;
}

.add-to-wishlist.active svg {
    fill: red;
    /* màu đỏ khi được click */
}

/* Đảm bảo nút không bị che */
.pc__btn-wl {
    z-index: 100;
    position: relative;
    cursor: pointer;
}
</style>


<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
        <div class="row">
            <div class="col-lg-7">
                <div class="product-single__media" data-media-type="vertical-thumbnail">

                    {{-- Khung ảnh lớn --}}
                    <div class="product-single__image">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                {{-- Ảnh chính --}}
                                @if($product->primaryImage)
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                        width="674" height="674" alt="{{ $product->name }}" />
                                    <a data-fancybox="gallery"
                                        href="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_zoom" />
                                        </svg>
                                    </a>
                                </div>
                                @endif

                                {{-- Các ảnh gallery (trừ ảnh chính) --}}
                                @foreach($product->galleryImages as $image)
                                @if(!$image->is_primary)
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('uploads/products/' . $image->imageName) }}" width="674"
                                        height="674" alt="{{ $product->name }}" />
                                    <a data-fancybox="gallery"
                                        href="{{ asset('uploads/products/' . $image->imageName) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_zoom" />
                                        </svg>
                                    </a>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div class="swiper-button-prev">
                                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_sm" />
                                </svg>
                            </div>
                            <div class="swiper-button-next">
                                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_sm" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Khung thumbnail nhỏ bên cạnh --}}
                    <div class="product-single__thumbnail">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @if($product->primaryImage)
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('uploads/products/thumbnails/' . $product->primaryImage->imageName) }}"
                                        width="104" height="104" alt="{{ $product->name }}" />
                                </div>
                                @endif

                                @foreach($product->galleryImages as $image)
                                @if(!$image->is_primary)
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('uploads/products/thumbnails/' . $image->imageName) }}"
                                        width="104" height="104" alt="{{ $product->name }}" />
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-lg-5">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Trang chủ</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Cửa hàng</a>
                    </div><!-- /.breadcrumb -->

                    <div
                        class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <a href="#" class="text-uppercase fw-medium"><svg width="10" height="10" viewBox="0 0 25 25"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg><span class="menu-link menu-link_us-s">Trước</span></a>
                        <a href="#" class="text-uppercase fw-medium"><span
                                class="menu-link menu-link_us-s">Sau</span><svg width="10" height="10"
                                viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg></a>
                    </div><!-- /.shop-acs -->
                </div>
                <h1 class="product-single__name">{{$product->name}}</h1>
                <div class="product-single__rating">
                    <div class="reviews-group d-flex">
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                    </div>
                    <!-- <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span> -->
                </div>
                <div class="product-single__price">
                    <span class="current-price">
                        @if($product->sale_price)
                        <s>{{number_format($product->regular_price, 0, ',', '.')}}</s>
                        {{number_format($product->sale_price, 0, ',' , '.')}}
                        @else
                        {{ number_format($product->regular_price, 0, ',', '.') }} VND</span>
                    @endif
                </div>
                <div class="product-single__short-desc">
                    <p>{{$product->short_description}}</p>
                </div>

                <form name="addtocart-form" action="{{ url('/cart/add') }}" method="POST">
                    @csrf
                    <div class="product-single__addtocart">
                        <div class="qty-control position-relative">
                            <input type="number" name="quantity" value="1" min="1"
                                class="qty-control__number text-center">
                            <div class="qty-control__reduce">-</div>
                            <div class="qty-control__increase">+</div>
                        </div><!-- .qty-control -->

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                    </div>
                </form>

                <div class="product-single__addtolinks">
                    <button type="button"
                        class="menu-link menu-link_us-s pc__btn-wl js-add-wishlist main-product-wishlist bg-transparent border-0"
                        data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                        data-product-image="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                        style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                        <svg width="16" height="16" viewBox="0 0 20 20">
                            <use href="#icon_heart" />
                        </svg>
                        <span>Yêu thích</span>
                    </button>


                    <share-button class="share-button">

                        <!--  -->

                        <!-- Nút chia sẻ -->
                        <button
                            class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center"
                            style="cursor:pointer; gap:6px; padding:6px 12px; font-weight:500; color:#2c3e50;">
                            <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_sharing" />
                            </svg>
                            <span>Chia sẻ</span>
                        </button>

                        <!-- Overlay nền tối mờ -->
                        <div id="modalOverlay" style="
    display:none; 
    position: fixed;
    inset: 0; 
    background: rgba(0,0,0,0.4); 
    z-index: 9998;
"></div>

                        <!-- Modal chia sẻ -->
                        <div id="shareModal" style="
    display:none;
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    padding: 24px 30px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    border-radius: 12px;
    z-index: 9999;
    max-width: 360px;
    width: 90%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
">
                            <p style="font-weight: 600; font-size: 18px; margin-bottom: 12px; color:#34495e;">Link chia
                                sẻ</p>
                            <input type="text" id="shareLink" readonly style="
        width: 100%;
        padding: 10px 14px;
        font-size: 16px;
        border: 2px solid #3498db;
        border-radius: 6px;
        color: #2c3e50;
        user-select: all;
        box-sizing: border-box;
    " />
                            <div
                                style="margin-top: 20px; text-align: right; display: flex; gap: 12px; justify-content: flex-end;">
                                <button id="copyBtn" style="
            padding: 8px 20px;
            background-color: #3498db;
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        " onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">
                                    Copy
                                </button>
                                <button id="closeBtn" style="
            padding: 8px 20px;
            background-color: #bdc3c7;
            border: none;
            border-radius: 6px;
            color: #2c3e50;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        " onmouseover="this.style.backgroundColor='#95a5a6'" onmouseout="this.style.backgroundColor='#bdc3c7'">
                                    Đóng
                                </button>
                            </div>
                        </div>

                        <!--  -->

                    </share-button>

                </div>
                <div class="product-single__meta-info">
                    <div class="meta-item">
                        <label>SKU:</label>
                        <span>{{$product->SKU}}</span>
                    </div>
                    <div class="meta-item">
                        <label>Categories:</label>
                        <span>{{$product->category->name}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-single__details-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                        href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Mô
                        tả</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
                        href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
                        aria-selected="false">Thông tin chi tiết</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
                        href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">
                        Đánh giá ({{ $product->reviews->count() }})
                    </a>

                </li>
            </ul>
            <!--  -->

            <div class="tab-content">
                {{-- Tab Mô tả --}}
                <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                    aria-labelledby="tab-description-tab">
                    <div class="product-single__description">
                        {{-- Nội dung từ short_description --}}
                        <p class="content">{{$product->short_description}}</p>
                    </div>
                </div>

                {{-- Tab Thông tin chi tiết --}}
                <div class="tab-pane fade" id="tab-additional-info" role="tabpanel"
                    aria-labelledby="tab-additional-info-tab">
                    <div class="product-single__description">
                        <h3 class="block-title mb-4">Chi tiết sản phẩm</h3>
                        {{-- Nội dung từ description --}}
                        <p class="content">{{$product->description}}</p>
                    </div>
                </div>

                {{-- Tab đánh giá giữ nguyên --}}
                <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">

                    <div class="product-single__reviews-list">
                        @forelse ($product->reviews as $review)
                        <div class="product-single__reviews-item">
                            <div class="customer-avatar">
                                <img loading="lazy"
                                    src="{{ $review->user && $review->user->avatar ? asset('storage/'.$review->user->avatar) : asset('assets/images/avatar.jpg') }}"
                                    alt="{{ $review->name }}" />
                            </div>
                            <div class="customer-review">
                                <div class="customer-name">
                                    <h6>{{ $review->name }}</h6>
                                    <div class="reviews-group d-flex">
                                        @for ($i = 1; $i <= 5; $i++) <svg class="review-star" viewBox="0 0 9 9"
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="fill: {{ $i <= $review->rating ? '#FFD700' : '#ccc' }}">
                                            <use href="#icon_star" />
                                            </svg>
                                            @endfor
                                    </div>
                                </div>
                                <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                                <div class="review-text">
                                    <p>{{ $review->content }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                        @endforelse
                    </div>
                    <!--  -->
                    <div class="product-single__review-form mt-5">
                        @auth
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <h5>Gửi đánh giá của bạn</h5>

                            {{-- CSS trực tiếp --}}
                            <style>
                            .pc__atc {
                                border-radius: 8px !important;
                            }


                            .btn.btn-primary {
                                background-color: #5E83AE !important;
                                border: none !important;
                                border-radius: 8px !important;
                            }

                            .btn.btn-primary:hover {
                                background-color: #4a6b8c !important;
                            }

                            .star-rating {
                                direction: rtl;
                                display: inline-flex;
                                font-size: 2rem;
                            }

                            .star-rating input[type=radio] {
                                display: none;
                            }

                            .star-rating label {
                                color: #ccc;
                                cursor: pointer;
                                transition: color 0.2s;
                            }

                            .star-rating label:hover,
                            .star-rating label:hover~label {
                                color: gold;
                            }

                            .star-rating input[type=radio]:checked~label {
                                color: gold;
                            }
                            </style>

                            {{-- Đánh giá sao --}}
                            <div class="select-star-rating mb-3">
                                <label for="rating">Đánh giá sản phẩm của bạn *</label>
                                <div class="star-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                    <label for="star{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>

                            {{-- Nội dung review --}}
                            <div class="mb-3">
                                <textarea name="content" class="form-control" rows="4" placeholder="Viết nhận xét..."
                                    required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                        @else
                        <p>Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để đánh giá sản phẩm.</p>
                        @endauth
                    </div>

                    <!--  -->
                </div>


            </div>


            <!--  -->
        </div>
    </section>
    <section class="products-carousel container">
        <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Sản phẩm <strong>Liên quan</strong></h2>


        <div id="related_products" class="position-relative">
            <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>

                <div class="swiper-wrapper">
                    @if(isset($rproducts) && $rproducts->count() > 0)
                    @foreach($rproducts as $rproduct)
                    <div class="swiper-slide product-card">

                        <!--  -->
                        <div class="pc__img-wrapper">
                            <a href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                                @if($rproduct->primaryImage)
                                <img loading="lazy"
                                    src="{{ asset('uploads/products/' . $rproduct->primaryImage->imageName) }}"
                                    width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">
                                @endif

                                @if($rproduct->images && $rproduct->images->count() > 1)
                                @php
                                // Lấy ảnh phụ đầu tiên
                                $secondImage = $rproduct->images->skip(1)->first();
                                @endphp
                                @if($secondImage)
                                <img loading="lazy" src="{{ asset('uploads/products/' . $secondImage->imageName) }}"
                                    width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img pc__img-second">
                                @endif
                                @endif
                            </a>
                            <!-- <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit"
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                    title="Add To Cart">
                                    Thêm vào giỏ hàng
                                </button>
                            </form> -->
                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $rproduct->id }}">
                                <button type="submit"
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                    title="Add To Cart">
                                    Thêm vào giỏ hàng
                                </button>
                            </form>

                        </div>


                        <!--  -->
                        <div class="pc__info position-relative">
                            <p class="pc__category">{{$rproduct->category->name}}</p>
                            <h6 class="pc__title">
                                <a href="{{route('shop.product.details', ['product_slug'=>$rproduct->slug])}}">
                                    {{$rproduct->name}}
                                </a>
                            </h6>
                            <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if($rproduct->sale_price)
                                    <s>{{number_format($rproduct->regular_price, 0, ',', '.') }} VND</s>
                                    {{number_format($rproduct->sale_price, 0, ',', '.') }} VND
                                    @else
                                    {{ number_format($rproduct->regular_price, 0, ',', '.') }} VND
                                    @endif
                                </span>
                            </div>
                            <!--  -->


                            <button
                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                data-product-id="{{ $rproduct->id }}" data-product-name="{{ $rproduct->name }}"
                                data-product-image="{{ asset('uploads/products/' . $rproduct->primaryImage->imageName) }}">
                                <svg width="16" height="16" viewBox="0 0 20 20">
                                    <use href="#icon_heart" />
                                </svg>
                            </button>





                            <!--  -->
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="swiper-slide">
                        <p class="text-center">Không có sản phẩm liên quan</p>
                    </div>
                    @endif
                </div><!-- /.swiper-wrapper -->

            </div><!-- /.swiper-container js-swiper-slider -->


            <div
                class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_md" />
                </svg>
            </div><!-- /.products-carousel__prev -->
            <div
                class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_md" />
                </svg>
            </div><!-- /.products-carousel__next -->

            <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
            <!-- /.products-pagination -->
        </div><!-- /.position-relative -->

    </section><!-- /.products-carousel container -->
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // ---- Xử lý Share Modal ----
    const shareBtn = document.querySelector('.to-share');
    const modal = document.getElementById('shareModal');
    const overlay = document.getElementById('modalOverlay');
    const shareLinkInput = document.getElementById('shareLink');
    const copyBtn = document.getElementById('copyBtn');
    const closeBtn = document.getElementById('closeBtn');

    function openModal() {
        const currentUrl = window.location.href.split('#')[0];
        shareLinkInput.value = currentUrl;
        modal.style.display = 'block';
        overlay.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
        overlay.style.display = 'none';
    }

    if (shareBtn) shareBtn.addEventListener('click', openModal);

    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            shareLinkInput.select();
            shareLinkInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(shareLinkInput.value).then(() => {
                alert('Đã sao chép link!');
                closeModal();
            });
        });
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });

    // ---- Reset sao đánh giá khi load trang ----
    document.querySelectorAll('.star-rating input[type=radio]').forEach(input => {
        input.checked = false;
    });

    // ---- Xử lý click trái tim ----
    document.addEventListener('click', function(e) {
        // Loại 1: .js-add-wishlist
        const btn1 = e.target.closest('.js-add-wishlist');
        if (btn1) {
            e.preventDefault();
            btn1.classList.toggle('icon-heart-active');
            return;
        }

        // Loại 2: .add-to-wishlist
        const btn2 = e.target.closest('.add-to-wishlist');
        if (btn2) {
            e.preventDefault();
            btn2.classList.toggle('active');

            // Đổi màu cho SVG bằng color (dành cho <use>)
            const svg = btn2.querySelector('svg');
            if (btn2.classList.contains('active')) {
                svg.style.color = 'red';
            } else {
                svg.style.color = '#666';
            }
        }
    });

});
</script>




@endsection