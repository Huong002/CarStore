@extends('layouts.app')
@section('content')

<style>
.js-add-wishlist svg {
    color: #666;
    cursor: pointer;
    transition: color 0.2s ease;
}

.js-add-wishlist.icon-heart-active svg {
    color: red !important;
}
</style>



<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
        <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            <div class="aside-header d-flex d-lg-none align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>

            <div class="pt-4 pt-lg-0"></div>

            <div class="accordion" id="filters">

                <!-- Accordion: Danh mục -->
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="heading-category">
                        <button class="accordion-button collapsed p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse-category" aria-expanded="false"
                            aria-controls="collapse-category">
                            Danh mục
                        </button>
                    </h5>
                    <div id="collapse-category" class="accordion-collapse collapse border-0"
                        aria-labelledby="heading-category" data-bs-parent="#filters">
                        <div class="accordion-body px-0 pb-0 pt-3" style="max-height: 250px; overflow-y: auto;">
                            <ul class="list list-inline mb-0">
                                @foreach($categories as $category)
                                <li class="list-item">
                                    <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                                        class="menu-link py-1">
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Accordion: Màu sắc -->
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="heading-color">
                        <button class="accordion-button collapsed p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse-color" aria-expanded="false"
                            aria-controls="collapse-color">
                            Màu sắc
                        </button>
                    </h5>
                    <div id="collapse-color" class="accordion-collapse collapse border-0"
                        aria-labelledby="heading-color" data-bs-parent="#filters">
                        <div class="accordion-body px-0 pb-0">
                            <div class="d-flex flex-wrap">
                                <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
                                <a href="#" class="swatch-color swatch_active js-filter" style="color: #bababa"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
                                <!-- ... -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thương hiệu -->
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="heading-brand">
                        <button class="accordion-button collapsed p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse-brand" aria-expanded="false"
                            aria-controls="collapse-brand">
                            Thương hiệu
                        </button>
                    </h5>
                    <div id="collapse-brand" class="accordion-collapse collapse border-0"
                        aria-labelledby="heading-brand" data-bs-parent="#filters">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <select class="d-none" multiple name="total-numbers-list">
                                <option value="1">Adidas</option>
                                <option value="2">Balmain</option>
                                <option value="3">Balenciaga</option>
                                <option value="4">Burberry</option>
                                <option value="5">Kenzo</option>
                                <option value="5">Givenchy</option>
                                <option value="5">Zara</option>
                            </select>
                            <div class="search-field__input-wrapper mb-3">
                                <input type="text" name="search_text"
                                    class="search-field__input form-control form-control-sm border-light border-2"
                                    placeholder="Tìm..." />
                            </div>
                            <ul class="multi-select__list list-unstyled">
                                @foreach($brands as $brand)
                                <li
                                    class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                    <span class="me-auto">{{$brand->name}}</span>
                                    <span class="text-secondary"></span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="accordion-item mb-4">
                    <h5 class="accordion-header mb-2" id="accordion-heading-price">
                        <button class="accordion-button collapsed p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="false"
                            aria-controls="accordion-filter-price">
                            Giá
                        </button>
                    </h5>
                    <div id="accordion-filter-price" class="accordion-collapse collapse border-0"
                        aria-labelledby="accordion-heading-price" data-bs-parent="#filters">

                        <!-- Slider giá: từ 500 triệu (500000000) đến 10 tỷ (10000000000) -->
                        <input class="price-range-slider" type="text" name="price_range" value=""
                            data-slider-min="500000000" data-slider-max="10000000000" data-slider-step="50000000"
                            data-slider-value="[2000000000,5000000000]" data-currency="₫" />

                        <div class="price-range__info d-flex align-items-center mt-2">
                            <div class="me-auto">
                                <span class="text-secondary">Giá tối thiểu: </span>
                                <span class="price-range__min">2,000,000,000 ₫</span>
                            </div>
                            <div>
                                <span class="text-secondary">Giá tối đa: </span>
                                <span class="price-range__max">5,000,000,000 ₫</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  -->
            </div>


        </div>

        <div class="shop-list flex-grow-1">
            <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0;">
                                <div class="slideshow-text container p-3 p-xl-5 text-center">
                                    <h2 class="text-uppercase section-title fw-bold mb-4 animate animate_fade animate_btt animate_delay-2"
                                        style="font-size: 2.2rem; line-height: 1.4;">
                                        KHÁM PHÁ <br>
                                        <span style="color:#5E83AE; font-size: 1.5rem;">Ô TÔ CAO CẤP</span>
                                    </h2>

                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5"
                                        style="font-size: 1rem; max-width: 550px; margin: 0 auto; line-height: 1.6; text-align: justify;">
                                        Tận hưởng trải nghiệm lái xe đỉnh cao với những mẫu xe sang trọng,
                                        hiện đại và công nghệ tiên tiến.
                                        Đa dạng lựa chọn: từ xe gia đình tiện nghi đến xe thể thao đẳng cấp.
                                    </p>

                                </div>



                            </div>
                            <div class="slide-split_media position-relative">
                                <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                    <img loading="lazy" src="assets/images/shop/shop_banner_cart2.jpg" width="630"
                                        height="450" alt="Women's accessories"
                                        class="slideshow-bg__img object-fit-cover" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0;">
                                <div class="slideshow-text container p-3 p-xl-5 text-center">
                                    <h2 class="text-uppercase section-title fw-bold mb-4 animate animate_fade animate_btt animate_delay-2"
                                        style="font-size: 2.2rem; line-height: 1.4;">
                                        KHÁM PHÁ <br>
                                        <span style="color:#5E83AE; font-size: 1.5rem;">Ô TÔ CAO CẤP</span>
                                    </h2>

                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5"
                                        style="font-size: 1rem; max-width: 550px; margin: 0 auto; line-height: 1.6; text-align: justify;">
                                        Tận hưởng trải nghiệm lái xe đỉnh cao với những mẫu xe sang trọng,
                                        hiện đại và công nghệ tiên tiến.
                                        Đa dạng lựa chọn: từ xe gia đình tiện nghi đến xe thể thao đẳng cấp.
                                    </p>
                                </div>


                            </div>
                            <div class="slide-split_media position-relative">
                                <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                    <img loading="lazy" src="assets/images/shop/shop_banner_car.jpg" width="630"
                                        height="450" alt="Women's accessories"
                                        class="slideshow-bg__img object-fit-cover" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0;">
                                <div class="slideshow-text container p-3 p-xl-5 text-center">
                                    <h2 class="text-uppercase section-title fw-bold mb-4 animate animate_fade animate_btt animate_delay-2"
                                        style="font-size: 2.2rem; line-height: 1.4;">
                                        KHÁM PHÁ <br>
                                        <span style="color:#5E83AE; font-size: 1.5rem;">Ô TÔ CAO CẤP</span>
                                    </h2>

                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5"
                                        style="font-size: 1rem; max-width: 550px; margin: 0 auto; line-height: 1.6; text-align: justify;">
                                        Tận hưởng trải nghiệm lái xe đỉnh cao với những mẫu xe sang trọng,
                                        hiện đại và công nghệ tiên tiến.
                                        Đa dạng lựa chọn: từ xe gia đình tiện nghi đến xe thể thao đẳng cấp.
                                    </p>
                                </div>

                            </div>
                            <div class="slide-split_media position-relative">
                                <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                    <img loading="lazy" src="assets/images/shop/shop_banner_cart1.jpg" width="630"
                                        height="450" alt="Women's accessories"
                                        class="slideshow-bg__img object-fit-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container p-3 p-xl-5">
                    <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2">
                    </div>

                </div>
            </div>

            <div class="mb-3 pb-2 pb-xl-3"></div>

            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Trang chủ</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Cửa hàng</a>
                </div>

                <div
                    class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">

                    <!-- Bộ sắp xếp -->
                    <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                        aria-label="Sắp xếp" name="sort">
                        <option selected>Mặc định</option>
                        <option value="1">Nổi bật</option>
                        <option value="2">Bán chạy</option>
                        <option value="3">Tên A-Z</option>
                        <option value="4">Tên Z-A</option>
                        <option value="5">Giá tăng dần</option>
                        <option value="6">Giá giảm dần</option>
                        <option value="7">Cũ nhất</option>
                        <option value="8">Mới nhất</option>
                    </select>

                    <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                    <!-- Chọn số cột hiển thị -->
                    <div class="col-size align-items-center order-1 d-none d-lg-flex">
                        <span class="text-uppercase fw-medium me-2">Hiển thị</span>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                            data-cols="2">2</button>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                            data-cols="3">3</button>
                        <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                            data-cols="4">4</button>
                    </div>

                    <!-- Nút bộ lọc (dành cho màn hình nhỏ) -->
                    <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                        <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                            data-aside="shopFilter">
                            <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_filter" />
                            </svg>
                            <span class="text-uppercase fw-medium d-inline-block align-middle">Bộ lọc</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @foreach($products as $product)
                <div class="product-card-wrapper">
                    <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <div class="swiper-container background-img js-swiper-slider"
                                data-settings='{"resizeObserver": true}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-wrapper">
                                        {{-- Ảnh chính --}}
                                        @if($product->primaryImage)
                                        <div class="swiper-slide">
                                            <a
                                                href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                                    alt="{{ $product->name }}" width="330" height="400"
                                                    class="pc__img" />
                                            </a>
                                        </div>
                                        @endif

                                        {{-- Ảnh phụ (loại bỏ ảnh chính để tránh trùng) --}}
                                        @foreach($product->images as $image)
                                        @if($image->is_primary == 0)
                                        <div class="swiper-slide">
                                            <a
                                                href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products/' . $image->imageName) }}"
                                                    alt="{{ $product->name }}" width="330" height="400"
                                                    class="pc__img" />
                                            </a>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>


                                </div>
                                <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></span>
                                <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></span>
                            </div>
                            <!--  -->
                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit"
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                    title="Add To Cart" style="border-radius: 8px;">
                                    Thêm vào giỏ hàng
                                </button>

                            </form>




                            <!--  -->
                        </div>

                        <div class="pc__info position-relative">
                            <p class="pc__category">{{$product->category->name}}</p>
                            <h6 class="pc__title"><a
                                    href="{{route('shop.product.details', $product->slug)}}">{{$product->name}}</a>
                            </h6>
                            <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if($product->sale_price)
                                    <s>{{number_format($product->regular_price, 0, ",", ".")}}VND</s>
                                    {{number_format($product->sale_price, 0, ",", ".")}}VND
                                    @else
                                    ${{number_format($product->regular_price, 0, ",", ".")}} VND
                                    @endif
                                </span>
                            </div>
                            <div class="product-card__review d-flex align-items-center">
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
                                <span
                                    class="reviews-note text-lowercase text-secondary ms-1">{{ $product->reviews->count() }}
                                    reviews</span>
                            </div>

                            <!--  -->
                            <button
                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                data-product-image="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                title="Add To Wishlist">
                                <svg width="16" height="16" viewBox="0 0 20 20">
                                    <use href="#icon_heart" />
                                </svg>
                            </button>

                            <!-- <button
                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                data-product-id="{{ $product->id }}" title="Add To Wishlist">
                                <svg width="16" height="16" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                    class="heart-svg">
                                    <path d="M10 18l-1.45-1.32C4.4 12.36 2 9.28 2 6.5 
                 2 4.5 3.5 3 5.5 3c1.54 0 3.04.99 3.57 
                 2.36h1.87C11.46 3.99 12.96 3 14.5 3 
                 16.5 3 18 4.5 18 6.5c0 2.78-2.4 5.86-6.55 
                 10.18L10 18z" />
                                </svg>
                            </button> -->



                        </div>
                    </div>
                </div>

                @endforeach
            </div>


            <nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
                <a href="#" class="btn-link d-inline-flex align-items-center">
                    <svg class="me-1" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_sm" />
                    </svg>
                    <span class="fw-medium">Trước</span>
                </a>
                <ul class="pagination mb-0">
                    <li class="page-item"><a class="btn-link px-1 mx-2 btn-link_active" href="#">1</a></li>
                    <li class="page-item"><a class="btn-link px-1 mx-2" href="#">2</a></li>
                    <li class="page-item"><a class="btn-link px-1 mx-2" href="#">3</a></li>
                    <li class="page-item"><a class="btn-link px-1 mx-2" href="#">4</a></li>
                </ul>
                <a href="#" class="btn-link d-inline-flex align-items-center">
                    <span class="fw-medium me-1">Sau</span>
                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_sm" />
                    </svg>
                </a>
            </nav>
        </div>

        <div class="divider"></div>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{$products->links('pagination::bootstrap-5')}}</div>

    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.js-add-wishlist');
        if (btn) {
            e.preventDefault();
            btn.classList.toggle('icon-heart-active');
        }
    });
});
</script>




@endsection