@extends('layouts.app')
@section('content')
<style>
    /* Filter sections styling */
    .filters-container .accordion {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .filters-container .accordion:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    .filters-container .accordion-item {
        border: none;
        background: transparent;
    }

    .filters-container .accordion-header {
        margin: 0;
    }

    .filters-container .accordion-button {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: none;
        padding: 16px 20px;
        font-weight: 600;
        color: #374151;
        position: relative;
        transition: all 0.3s ease;
    }

    .filters-container .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: none;
    }

    .filters-container .accordion-button:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        border-color: transparent;
    }

    .filters-container .accordion-button::after {
        background-image: none;
        content: '';
        width: 16px;
        height: 16px;
        background: currentColor;
        mask: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23374151'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") no-repeat;
        mask-size: contain;
        transition: transform 0.3s ease;
    }

    .filters-container .accordion-button:not(.collapsed)::after {
        transform: rotate(180deg);
    }

    .filters-container .accordion-collapse {
        border-top: 1px solid #e5e7eb;
    }

    .filters-container .accordion-body {
        padding: 20px;
        background: #ffffff;
    }

    /* Category and Brand list styling */
    .filters-container .list-item {
        padding: 8px 0;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s ease;
    }

    .filters-container .list-item:last-child {
        border-bottom: none;
    }

    .filters-container .list-item:hover {
        background-color: #f8fafc;
        border-radius: 6px;
        margin: 0 -8px;
        padding-left: 8px;
        padding-right: 8px;
    }

    .filters-container input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #3b82f6;
        border-radius: 4px;
    }

    .filters-container label {
        cursor: pointer;
        font-weight: 500;
        color: #374151;
        transition: color 0.2s ease;
    }

    .filters-container label:hover {
        color: #3b82f6;
    }

    /* Color swatches styling */
    .swatch-color-label {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        position: relative;
        padding: 4px;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .swatch-color-label:hover {
        background-color: #f3f4f6;
    }

    .swatch-box {
        width: 28px;
        height: 28px;
        border: 3px solid #e5e7eb;
        border-radius: 50%;
        display: inline-block;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .swatch-checkbox:checked+.swatch-box {
        border-color: #3b82f6;
        transform: scale(1.15);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .swatch-checkbox:checked+.swatch-box::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
        font-size: 12px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* Search field styling */
    .search-field__input {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 10px 12px;
        transition: all 0.3s ease;
    }

    .search-field__input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Apply filters button */
    #applyFilters {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
    }

    #applyFilters:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .pc__atc {
        background-color: white;
        padding: 10px 16px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.6s ease-out;
    }

    .pc__atc:hover {
        transform: scale(1.05);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim_appear-bottom {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .btn-wrapper {
        background-color: #fff;
        border-radius: 12px;
        padding: 10px 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }

    .btn-wrapper .btn:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    .color-swatches {
        gap: 8px;
    }

    .swatch-color-label {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        position: relative;
    }

    .swatch-box {
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 50%;
        display: inline-block;
        transition: border-color 0.3s, transform 0.2s;
    }

    .swatch-checkbox:checked+.swatch-box {
        border-color: #007bff;
        transform: scale(1.1);
    }

    .swatch-checkbox:focus+.swatch-box {
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5);
    }
</style>

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


            <!-- Thêm thanh tìm kiếm với nút quét hình ảnh -->
            <div class="search-field mb-4 d-flex align-items-center">
                <div class="search-field__input-wrapper position-relative flex-grow-1 me-2">
                    <input type="text" name="search_product"
                        class="search-field__input form-control form-control-sm border-light border-2"
                        placeholder="Tìm kiếm sản phẩm..." value="{{ $search ?? '' }}" />
                </div>
                <!-- <div class="search-field__input-wrapper position-relative flex-grow-1 me-2">
                    <input type="text" name="search_product" class="search-field__input form-control form-control-sm border-light border-2" placeholder="Tìm kiếm sản phẩm..." />

                </div> -->

                <button class="scan-button btn btn-outline-secondary border-0 p-2" title="Quét hình ảnh">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3.17a2 2 0 0 0 1.41-.59l1.83-1.82A2 2 0 0 1 10.83 2h2.34a2 2 0 0 1 1.42.59l1.83 1.82A2 2 0 0 0 17.83 5H21a2 2 0 0 1 2 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                </button>
            </div>


            <div class="accordion" id="filters">

                {{-- Danh mục --}}
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-category">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-category" aria-expanded="true"
                            aria-controls="accordion-filter-category">
                            Danh mục
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="..."></path>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-category" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-category">
                        <div class="accordion-body px-0 pb-0 pt-3" style="max-height: 250px; overflow-y: auto;">
                            <ul class="list list-inline mb-0">
                                @foreach($allCategories as $category)
                                <li class="list-item d-flex align-items-center py-1">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        id="category_{{ $category->id }}" class="me-2"
                                        {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}>
                                    <label for="category_{{ $category->id }}"
                                        class="menu-link py-1">{{ $category->name }}</label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Màu sắc --}}
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-color">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-color" aria-expanded="true"
                            aria-controls="accordion-filter-color">
                            Màu sắc
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="..."></path>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-color" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-color">
                        <div class="accordion-body px-0 pb-0">
                            <div class="d-flex flex-wrap">
                                @foreach($allColors as $color)
                                <label class="swatch-color-label me-2 mb-2" for="color_{{ $color->id }}"
                                    title="{{ $color->name }}">
                                    <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                        id="color_{{ $color->id }}" class="swatch-checkbox" style="display: none;"
                                        {{ in_array($color->id, $selectedColorIds) ? 'checked' : '' }}>
                                    <span class="swatch-box" style="background-color: {{ $color->colorCode }};"></span>

                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Thương hiệu --}}
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-brand">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                            aria-controls="accordion-filter-brand">
                            Thương hiệu
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="..."></path>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-brand">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <div class="search-field__input-wrapper mb-3">
                                <input type="text" name="search_text"
                                    class="search-field__input form-control form-control-sm border-light border-2"
                                    placeholder="Tìm kiếm sản phẩm...." />
                            </div>
                            <ul class="multi-select__list list-unstyled">
                                @foreach($allBrands as $brand)
                                <li class="list-item d-flex align-items-center py-1">
                                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                        id="brand_{{ $brand->id }}" class="me-2"
                                        {{ in_array($brand->id, $selectedBrandIds) ? 'checked' : '' }}>
                                    <label for="brand_{{ $brand->id }}"
                                        class="menu-link py-1">{{ $brand->name }}</label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 
            <div class="accordion" id="price-filters">
                <div class="accordion-item mb-4">
                    <h5 class="accordion-header mb-2" id="accordion-heading-price">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                            Giá
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                        <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="10"
                            data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]" data-currency="$" />
                        <div class="price-range__info d-flex align-items-center mt-2">
                            <div class="me-auto">
                                <span class="text-secondary">Thấp nhất: </span>
                                <span class="price-range__min">{{$minPrice}}</span>
                            </div>
                            <div>
                                <span class="text-secondary">Cao nhất: </span>
                                <span class="price-range__max">{{$maxPrice}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->


            <div class="accordion-body px-0 pb-0">
                <button id="applyFilters" class="btn btn-primary">Áp dụng bộ lọc</button>
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
                    <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Trang
                        chủ</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="{{ route('shop.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Cửa
                        hàng</a>
                </div>

                <div
                    class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                    <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                        aria-label="Sort Items" name="sort" id="sortSelect">
                        <option value="" {{ ($sortBy ?? '') == '' ? 'selected' : '' }}>Sắp xếp mặc định</option>
                        <option value="1" {{ ($sortBy ?? '') == '1' ? 'selected' : '' }}>Nổi bật</option>
                        <!-- <option value="2" {{ ($sortBy ?? '') == '2' ? 'selected' : '' }}>Bán chạy nhất</option> -->
                        <option value="3" {{ ($sortBy ?? '') == '3' ? 'selected' : '' }}>Theo bảng chữ cái, A-Z</option>
                        <option value="4" {{ ($sortBy ?? '') == '4' ? 'selected' : '' }}>Theo bảng chữ cái, Z-A</option>
                        <option value="5" {{ ($sortBy ?? '') == '5' ? 'selected' : '' }}>Giá, thấp đến cao</option>
                        <option value="6" {{ ($sortBy ?? '') == '6' ? 'selected' : '' }}>Giá, cao đến thấp</option>
                        <option value="7" {{ ($sortBy ?? '') == '7' ? 'selected' : '' }}>Ngày, cũ đến mới</option>
                        <option value="8" {{ ($sortBy ?? '') == '8' ? 'selected' : '' }}>Ngày, mới đến cũ</option>
                    </select>

                    <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                    <div class="col-size align-items-center order-1 d-none d-lg-flex">
                        <span class="text-uppercase fw-medium me-2">View</span>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                            data-cols="2">2</button>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                            data-cols="3">3</button>
                        <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                            data-cols="4">4</button>
                    </div>

                    <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                        <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                            data-aside="shopFilter">
                            <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_filter" />
                            </svg>
                            <span class="text-uppercase fw-medium d-inline-block align-middle">Lọc</span>
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
                                    {{-- Ảnh chính --}}
                                    @if($product->primaryImage)
                                    <div class="swiper-slide">
                                        <a
                                            href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                            <img loading="lazy"
                                                src="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                                alt="{{ $product->name }}" width="330" height="400" class="pc__img" />
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
                                                alt="{{ $product->name }}" width="330" height="400" class="pc__img" />
                                        </a>
                                    </div>
                                    @endif
                                    @endforeach
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
                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                    title="Add To Cart" style="border-radius: 8px;">
                                    Thêm vào giỏ hàng
                                </button>

                            </form>



                        </div>

                        <div class="pc__info position-relative">
                            <p class="pc__category">{{$product->category->name}}</p>
                            <h6 class="pc__title"><a
                                    href="{{route('shop.product.details', $product->slug)}}">{{$product->name}}</a></h6>
                            <!-- <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if($product->sale_price)
                                    <s>{{number_format($product->regular_price, 0, ",", ".")}}VNĐ</s>
                                    {{number_format($product->sale_price, 0, ",", ".")}}VNĐ
                                    @else
                                    {{number_format($product->regular_price, 0, ",", ".")}} VNĐ
                                    @endif
                                </span>
                            </div> -->
                            <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if($product->sale_price > 0)
                                    <s>{{ number_format($product->regular_price, 0, ",", ".") }} VNĐ</s>
                                    {{ number_format($product->sale_price, 0, ",", ".") }} VNĐ
                                    @else
                                    {{ number_format($product->regular_price, 0, ",", ".") }} VNĐ
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
                                <span class="reviews-note text-lowercase text-secondary ms-1">
                                    {{ $product->reviews_count }} đánh giá
                                </span>
                            </div>

                            <!-- <button
                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                data-product-image="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                title="Add To Wishlist">
                                <svg width="16" height="16" viewBox="0 0 20 20">
                                    <use href="#icon_heart" />
                                </svg>
                            </button> -->
                            <button
                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                data-product-slug="{{ $product->slug }}"
                                data-product-image="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                title="Add To Wishlist">
                                <svg width="16" height="16" viewBox="0 0 20 20">
                                    <use href="#icon_heart" />
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>

                @endforeach
            </div>

            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$products->links('pagination::bootstrap-5')}}
            </div>
        </div>


        <div class="divider"></div>


    </section>
</main>



<!-- Modal để tải ảnh -->
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scanModalLabel">Tải ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <fieldset>

                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="{{ asset('images/upload/upload-1.png') }}" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load text-center">
                            <style>
                                .camera-upload-btn {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    width: 120px;
                                    height: 120px;
                                    margin: 0 auto;
                                    background: #f4f6fa;
                                    border-radius: 50%;
                                    box-shadow: 0 2px 12px rgba(94, 131, 174, 0.08);
                                    cursor: pointer;
                                    border: 2px solid #e0e6ed;
                                    transition: box-shadow 0.2s, border-color 0.2s;
                                }

                                .camera-upload-btn:hover {
                                    box-shadow: 0 4px 24px rgba(94, 131, 174, 0.18);
                                    border-color: #5E83AE;
                                }

                                .camera-upload-btn i {
                                    font-size: 3.5rem;
                                    color: #5E83AE;
                                    transition: color 0.2s;
                                }

                                .camera-upload-btn span {
                                    margin-top: 10px;
                                    font-size: 1.1rem;
                                    color: #5E83AE;
                                    font-weight: 500;
                                }

                                @media (max-width: 600px) {
                                    .camera-upload-btn {
                                        width: 90px;
                                        height: 90px;
                                    }

                                    .camera-upload-btn i {
                                        font-size: 2.2rem;
                                    }
                                }
                            </style>
                            <label class="camera-upload-btn" for="myFile">
                                <i class="bi bi-camera" aria-hidden="true"></i>
                                <input type="file" id="myFile" name="image" accept="image/*" style="display:none;">
                            </label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="submitImage">Xác nhận</button>
            </div>
        </div>
    </div>
</div>



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
<script>
    $(document).ready(function() {
        const searchInput = $('input[name="search_product"]');
        const scanButton = $(".scan-button");
        const myFileInput = $("#myFile");
        const submitImageBtn = $("#submitImage");
        const applyFiltersBtn = $("#applyFilters");
        const sortSelect = $("#sortSelect");

        // Log kiểm tra
        console.log("scanButton:", scanButton.length);
        console.log("myFileInput:", myFileInput.length);
        console.log("submitImageBtn:", submitImageBtn.length);
        console.log("filterSearch:", applyFiltersBtn.length);
        console.log("sortSelect:", sortSelect.length);

        //  hien thi modal cho scan 
        scanButton.on("click", function(e) {
            e.preventDefault();
            var modal = new bootstrap.Modal(document.getElementById("scanModal"));
            modal.show();
        });
        // ham tim kiem. nhant u khoa tu tim kiem, sa do chuyen huong den trinh duye url moi
        // function performSearch(searchTerm) {
        //     if (searchTerm) {
        //         const url = new URL(window.location.href);
        //         url.searchParams.set("search", searchTerm);
        //         window.location.href = url.toString();
        //     }
        // }
        // Thay đổi hàm performSearch để xử lý tất cả các tham số lọc
        function performSearch(searchTerm, categories = [], colors = [], brands = [], sortBy = '') {
            const url = new URL(window.location.href);

            // Reset các tham số tìm kiếm trước đó
            url.searchParams.delete("search");
            url.searchParams.delete("categories");
            url.searchParams.delete("colors");
            url.searchParams.delete("brands");
            url.searchParams.delete("sort");

            if (searchTerm) url.searchParams.set("search", searchTerm);

            if (categories && categories.length) {
                url.searchParams.set("categories", categories.join(','));
            }

            if (colors && colors.length) {
                url.searchParams.set("colors", colors.join(','));
            }

            if (brands && brands.length) {
                url.searchParams.set("brands", brands.join(','));
            }

            if (sortBy) {
                url.searchParams.set("sort", sortBy);
            }

            // Chuyển hướng đến URL mới
            window.location.href = url.toString();
        }

        // Preview ảnh khi chọn file
        myFileInput.on("change", function() {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr("src", URL.createObjectURL(file));
                $("#imgpreview").show();
                $("#upload-file").hide();
                console.log("Đã chọn file, preview ảnh.");
            } else {
                $("#imgpreview").hide();
                $("#upload-file").show();
                console.log("Không có file, ẩn preview.");
            }
        });

        submitImageBtn.on("click", function() {
            const file = myFileInput[0].files[0];
            if (file) {
                const formData = new FormData();
                formData.append("image", file);

                fetch("{{ route('shop.scan.image') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log("Kết quả trả về từ server:", data);
                        if (data.car_name) {
                            searchInput.val(data.car_name);
                            performSearch(data.car_name);
                            var modal = bootstrap.Modal.getInstance(document.getElementById(
                                "scanModal"));
                            if (modal) modal.hide();
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            }
        });

        // Xử lý sắp xếp
        sortSelect.on("change", function() {
            const sortValue = $(this).val();
            const searchTerm = searchInput.val() || '';
            const categories = $('input[name="categories[]"]:checked').map(function() {
                return this.value;
            }).get();
            const colors = $('input[name="colors[]"]:checked').map(function() {
                return this.value;
            }).get();
            const brands = $('input[name="brands[]"]:checked').map(function() {
                return this.value;
            }).get();

            console.log("Sort changed:", sortValue);
            performSearch(searchTerm, categories, colors, brands, sortValue);
        });

        // xu li cho bo loc 
        applyFiltersBtn.on("click", function(e) {
            e.preventDefault(); // Ngăn hành vi mặc định của button
            const searchTerm = searchInput.val() || '';
            const sortValue = sortSelect.val() || '';
            const categories = $('input[name="categories[]"]:checked').map(function() {
                return this.value;
            }).get();
            const colors = $('input[name="colors[]"]:checked').map(function() {
                return this.value;
            }).get();
            const brands = $('input[name="brands[]"]:checked').map(function() {
                return this.value;
            }).get();

            console.log("Filters:", {
                searchTerm,
                categories,
                colors,
                brands,
                sortValue
            }); // Debug
            performSearch(searchTerm, categories, colors, brands, sortValue);
        });
        $(document).on('click', '.js-add-wishlist', function(e) {
            e.preventDefault();

            $(this).toggleClass('active'); // Toggle class active để đổi màu icon
        });

        // Xử lý thêm sản phẩm vào giỏ hàng
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();

            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const productPrice = $(this).data('product-price');
            const quantity = 1; // Mặc định thêm 1 sản phẩm

            // Hiển thị hiệu ứng đang xử lý
            $(this).html('<i class="fas fa-spinner fa-spin"></i> Đang thêm...');
            const $btn = $(this);

            // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Hiển thị thông báo thành công
                    $btn.html('<i class="fas fa-check me-1"></i> Đã thêm');

                    // Cập nhật số lượng sản phẩm trong giỏ hàng trên header (nếu có)
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }

                    // Hiển thị thông báo
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Đã thêm ' + productName + ' vào giỏ hàng',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Khôi phục trạng thái ban đầu của nút sau 2 giây
                    setTimeout(function() {
                        $btn.html(
                            '<i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ'
                        );
                    }, 2000);
                },
                error: function(error) {
                    // Hiển thị thông báo lỗi
                    $btn.html('<i class="fas fa-exclamation-triangle me-1"></i> Lỗi');

                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Không thể thêm sản phẩm vào giỏ hàng',
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                    });

                    // Khôi phục trạng thái ban đầu của nút sau 2 giây
                    setTimeout(function() {
                        $btn.html(
                            '<i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ'
                        );
                    }, 2000);

                    console.error('Lỗi khi thêm vào giỏ hàng:', error);
                }
            });
        });
    });
</script>


@endsection