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
                            <div class="swiper-wrapper">
                                <!-- Sản phẩm 1 -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/65/8c/3c/658c3c20d9177e8b0f2ecf25078956f0.jpg"
                                                width="258" height="313" alt="SUV VinFast VF8" class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/2e/ab/6e/2eab6ecf404e980238105cafe7af2fd1.jpg"
                                                width="258" height="313" alt="SUV VinFast VF8"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">SUV VinFast VF8</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">1.100.000.000đ</span>
                                        </div>

                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/736x/32/ff/f4/32fff4675a3f0ff190fe7b35848fce00.jpg"
                                                width="258" height="313" alt="Sedan Toyota Camry" class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/8b/b5/59/8bb5594d6125b99e4d84078323b2f958.jpg"
                                                width="258" height="313" alt="Sedan Toyota Camry"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">Sedan Toyota Camry</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">1.300.000.000đ</span>
                                        </div>

                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=500"
                                                width="258" height="313" alt="Xe bán tải Ford Ranger" class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/736x/06/97/6c/06976cbfe50e65f0dca81f8e9160c775.jpg"
                                                width="258" height="313" alt="Xe bán tải Ford Ranger"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">Bán tải Ford Ranger</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">950.000.000đ</span>
                                        </div>

                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/f2/80/f0/f280f01554772fa66bfd134cd3b9ae7b.jpg"
                                                width="258" height="313" alt="Xe điện Tesla Model 3" class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/736x/92/13/71/921371897d891b5d3f668f5b22f4cb37.jpg"
                                                width="258" height="313" alt="Xe điện Tesla Model 3"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">Xe điện Tesla Model 3</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">1.600.000.000đ</span>
                                        </div>
                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none"><svg width="18" height="18"
                                                        viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg></span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/736x/50/0e/75/500e755ec43754249f1b83cecc91f4f7.jpg"
                                                width="258" height="313" alt="Xe thể thao Porsche 911" class="pc__img">
                                            <img loading="lazy"
                                                src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=500"
                                                width="258" height="313" alt="Xe thể thao Porsche 911"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">Xe thể thao Porsche 911</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">8.000.000.000đ</span>
                                        </div>
                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none"><svg width="18" height="18"
                                                        viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg></span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/736x/b0/bf/c2/b0bfc2954a4ce2de70416781ad032614.jpg"
                                                width="258" height="313" alt="Xe SUV Hyundai SantaFe" class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/736x/f7/ba/a7/f7baa7cae27281561340d198b523ef9f.jpg"
                                                width="258" height="313" alt="Xe SUV Hyundai SantaFe"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">SUV Hyundai SantaFe</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">1.250.000.000đ</span>
                                        </div>
                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none"><svg width="18" height="18"
                                                        viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg></span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/57/98/7b/57987b448a30a99b2c273024cb1c0065.jpg"
                                                width="258" height="313" alt="Xe hạng sang Mercedes S-Class"
                                                class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/84/41/ad/8441add31767cb7b411ef0edf2ec0124.jpg"
                                                width="258" height="313" alt="Xe hạng sang Mercedes S-Class"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">Mercedes S-Class</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">5.200.000.000đ</span>
                                        </div>
                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none"><svg width="18" height="18"
                                                        viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg></span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="#">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/bd/e7/3b/bde73be1eda914aa1493650a870ab3c2.jpg"
                                                width="258" height="313" alt="Hatchback Kia Morning" class="pc__img">
                                            <img loading="lazy"
                                                src="https://i.pinimg.com/1200x/af/47/8a/af478a43a2aef520b8074cfbd6b5a0c4.jpg"
                                                width="258" height="313" alt="Hatchback Kia Morning"
                                                class="pc__img pc__img-second">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="#">Mazda CX-5</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">999.000.000đ</span>
                                        </div>
                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Đặt cọc">Đặt Cọc</button>
                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Xem nhanh">
                                                <span class="d-none d-xxl-block">Xem nhanh</span>
                                                <span class="d-block d-xxl-none">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <!--  -->
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.swiper-wrapper -->
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

            <div class="row">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/1200x/f0/90/ed/f090edc3dc9e5fa30d85f6e4ddcba72c.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="#">BMW X5 2025</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">4.300.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/1200x/a7/5b/52/a75b52dc9a601dc622a21af047743873.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="#">Mercedes-Benz C-Class 2025</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">1.900.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/1200x/e3/3c/a3/e33ca37cd1f6336a0f5253a0b0c84662.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                            <div class="product-label text-uppercase bg-white top-0 left-0 mt-2 mx-2">Mới</div>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="#">Porsche 911 Carrera 2025</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">8.500.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/1200x/85/78/1c/85781c5edc7c5a30fb420bae24907d22.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                            <div class="product-label bg-red text-white right-0 top-0 left-auto mt-2 mx-2">-6%</div>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title">Ferrari F8 Tributo 2025</h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price-old">15.000.000.000đ</span>
                                <span class="money price text-secondary">14.500.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/736x/09/de/a5/09dea57c18cbfc47b3e3eeba6d40bcd2.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="#">Tesla Model 3 2025</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">1.600.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/736x/dc/8b/e1/dc8be1dc1756a7d9e2a110492002060b.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="#">Mazda CX-5 2025</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">999.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/736x/2a/56/c3/2a56c39c9d02e34a94ed91ac31adf721.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="#">Honda CR-V 2025</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">1.100.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="#">
                                <img loading="lazy"
                                    src="https://i.pinimg.com/736x/18/2c/a4/182ca4435c3d50e389c01095c74fda1e.jpg"
                                    width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title">Hyundai Santa Fe 2025</h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price-old">1.300.000.000đ</span>
                                <span class="money price text-secondary">1.250.000.000đ</span>
                            </div>

                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Đặt cọc</button>
                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                    <span class="d-none d-xxl-block">Xem nhanh</span>
                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view" />
                                        </svg></span>
                                </button>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->

            <div class="text-center mt-2">
                <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#"> Xem Thêm</a>
            </div>
        </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>


@endsection