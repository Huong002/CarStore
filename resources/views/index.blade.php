@extends('layouts.app')
@section('content')
<style>
    /* Dịch ảnh lại gần hơn với phần character_markup */
    .slideshow-character__img {
        position: relative;
        left: -40px;
        /* điều chỉnh số pixel tùy ý (âm = dịch sang trái) */
    }

    .character_markup {
        top: 40%;
        /* chỉnh theo ý để canh khoảng trống */
        transform: translateX(-50%);
        text-align: center;
    }
</style>

<main>

    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
    "autoplay": {
      "delay": 5000
    },
    "slidesPerView": 1,
    "effect": "fade",
    "loop": true
  }'>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-character position-absolute pos_right-center" style="bottom:120px;">
                        <img loading="lazy" src="{{ asset('assets/images/home/slideshow-character01.jpg') }}"
                            width="800" height="900" alt="Woman Fashion 1"
                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                    </div>


                    <!-- Chữ Dòng xe được đưa ra ngoài để cùng cấp -->
                    <div class="character_markup position-absolute start-50 top-50 translate-middle-x">
                        <p
                            class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                            Dòng xe
                        </p>
                    </div>

                    <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                        <h6
                            class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                            Mẫu xe mới
                        </h6>
                        <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Phiên bản</h2>
                        <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">2025</h2>
                        <a href="#"
                            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">
                            Xem Ngay
                        </a>
                    </div>
                </div>
            </div>


            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-character position-absolute pos_right-center" style="bottom:120px;">
                        <img loading="lazy" src="{{ asset('assets/images/home/slideshow-character11.jpg') }}"
                            width="800" height="900" alt="Woman Fashion 1"
                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                    </div>


                    <!-- Chữ Dòng xe được đưa ra ngoài để cùng cấp -->
                    <div class="character_markup position-absolute start-50 top-50 translate-middle-x">
                        <p
                            class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                            Dòng xe
                        </p>
                    </div>

                    <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                        <h6
                            class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                            Mẫu xe mới
                        </h6>
                        <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Phiên bản</h2>
                        <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">2025</h2>
                        <a href="#"
                            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">
                            Xem Ngay
                        </a>
                    </div>
                </div>
            </div>


            <div class="container">
                <div
                    class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
                </div>
            </div>
    </section>
    <div class="container mw-1620 bg-white border-radius-10">
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        <section class="category-carousel container">
            <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Mẫu xe gợi ý cho bạn</h2>

            <div class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": 8,
          "slidesPerGroup": 1,
          "effect": "none",
          "loop": true,
          "navigation": {
            "nextEl": ".products-carousel__next-1",
            "prevEl": ".products-carousel__prev-1"
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "slidesPerGroup": 2,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 4,
              "slidesPerGroup": 4,
              "spaceBetween": 30
            },
            "992": {
              "slidesPerView": 6,
              "slidesPerGroup": 1,
              "spaceBetween": 45,
              "pagination": false
            },
            "1200": {
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "spaceBetween": 60,
              "pagination": false
            }
          }
        }'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://i.pinimg.com/1200x/b2/e7/eb/b2e7ebd7fd3e312c861406c2f0e0f616.jpg"
                                width="124" height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />SUV</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=300" width="124"
                                height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Sedan</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://images.unsplash.com/photo-1502877338535-766e1452684a?w=300" width="124"
                                height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Bán tải</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://i.pinimg.com/736x/af/36/23/af36239f65229fefbc7f9032b430b25c.jpg"
                                width="124" height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Điện</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=300" width="124"
                                height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Thể thao</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://i.pinimg.com/736x/07/59/17/075917037494787cfa82ffda0ffa7d3c.jpg"
                                width="124" height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Hạng sang</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://i.pinimg.com/1200x/4f/a8/5a/4fa85a9e9880b3b36ca883d5c2a579cd.jpg"
                                width="124" height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Convertible</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3"
                                src="https://i.pinimg.com/1200x/f7/46/84/f74684643adef340f66e388e075301b9.jpg"
                                width="124" height="124" alt="" />
                            <div class="text-center">
                                <a href="#" class="menu-link fw-medium">Xe<br />Crossover</a>
                            </div>
                        </div>
                    </div>



        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="hot-deals container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Ưu đãi nổi bật</h2>
            <div class="row">
                <div
                    class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                    <h2>Khuyến mãi mùa hè</h2>
                    <h2 class="fw-bold">Ưu đãi đến 60%</h2>

                    <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                        data-date="18-3-2024" data-time="06:50">
                        <div class="day countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Ngày</span>
                        </div>

                        <div class="hour countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Giờ</span>
                        </div>

                        <div class="min countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Phút</span>
                        </div>

                        <div class="sec countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Giây</span>
                        </div>
                    </div>

                    <a href="#" class="btn-link default-underline text-uppercase fw-medium mt-3">Xem tất cả</a>
                </div>

                <div class="col-md-6 col-lg-8 col-xl-80per">
                    <div class="position-relative">
                        <div class="swiper-container js-swiper-slider" data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 4,
              "slidesPerGroup": 4,
              "effect": "none",
              "loop": false,
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 14
                },
                "768": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 3,
                  "spaceBetween": 24
                },
                "992": {
                  "slidesPerView": 3,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                }
              }
            }'>
                            <!--  -->

                            <div class="swiper-wrapper">
                                @foreach($products->take(4) as $product)
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a
                                            href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                            {{-- Ảnh chính --}}
                                            <img loading="lazy"
                                                src="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                                width="258" height="313" alt="{{ $product->name }}" class="pc__img">
                                            {{-- Ảnh phụ nếu có --}}
                                            @php
                                            $secondImage = $product->images->firstWhere('is_primary', 0);
                                            @endphp
                                            @if($secondImage)
                                            <img loading="lazy"
                                                src="{{ asset('uploads/products/' . $secondImage->imageName) }}"
                                                width="258" height="313" alt="{{ $product->name }}"
                                                class="pc__img pc__img-second">
                                            @endif
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title">
                                            <a
                                                href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">
                                                @if($product->sale_price)
                                                <s>{{ number_format($product->regular_price, 0, ',', '.') }}đ</s>
                                                {{ number_format($product->sale_price, 0, ',', '.') }}đ
                                                @else
                                                {{ number_format($product->regular_price, 0, ',', '.') }}đ
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div><!-- /.swiper-wrapper -->


                            <!--  -->
                        </div><!-- /.swiper-container js-swiper-slider -->
                    </div><!-- /.position-relative -->
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="category-banner container">
            <div class="row">
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="h-auto"
                            src="https://i.pinimg.com/736x/b0/bf/c2/b0bfc2954a4ce2de70416781ad032614.jpg" width="690"
                            height="665" alt="" />
                        <div class="category-banner__item-mark">
                            Giá chỉ từ 500.000.000 triệu
                        </div>
                        <div class="category-banner__item-content">
                            <h3 class="mb-0">Ưu đãi SUV</h3>
                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Xem Ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="h-auto"
                            src="https://i.pinimg.com/736x/b0/bf/c2/b0bfc2954a4ce2de70416781ad032614.jpg" width="690"
                            height="665" alt="" />
                        <div class="category-banner__item-mark">
                            Giá chỉ từ 700.000.000 triệu
                        </div>
                        <div class="category-banner__item-content">
                            <h3 class="mb-0">Xe Điện Mới</h3>
                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Xem Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="products-grid container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Sản Phẩm Nổi Bật</h2>

            <!--  -->
            <div class="row">
                @foreach($products->reverse()->take(8) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                {{-- Ảnh chính --}}
                                <img loading="lazy"
                                    src="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                                    width="330" height="400" alt="{{ $product->name }}" class="pc__img">

                                {{-- Ảnh phụ nếu có --}}
                                @php
                                $secondImage = $product->images->firstWhere('is_primary', 0);
                                @endphp
                                @if($secondImage)
                                <img loading="lazy" src="{{ asset('uploads/products/' . $secondImage->imageName) }}"
                                    width="330" height="400" alt="{{ $product->name }}" class="pc__img pc__img-second">
                                @endif

                                {{-- THÊM nhãn Mới vào sản phẩm thứ 3 --}}
                                @if($loop->iteration === 2)
                                <div class="product-label text-uppercase bg-white top-0 left-0 mt-2 mx-2">
                                    Mới
                                </div>
                                @endif

                                {{-- THÊM nhãn -6% vào sản phẩm thứ 7 --}}
                                @if($loop->iteration === 7)
                                <div class="product-label bg-red text-white right-0 top-0 left-auto mt-2 mx-2">
                                    -6%
                                </div>
                                @endif
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title">
                                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <div class="product-card__price d-flex align-items-center">
                                @if($product->sale_price)
                                <span
                                    class="money price-old">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                                <span
                                    class="money price text-secondary">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                @else
                                <span
                                    class="money price text-secondary">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!--  -->
            <!-- <div class="text-center mt-2">
                <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#"> Xem Thêm</a>
            </div> -->
        </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>


@endsection