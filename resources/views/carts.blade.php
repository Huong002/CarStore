@extends('layouts.app')
@section('content')
<main class="pt-90">
    <section class="shop-checkout container">
        <h2 class="page-title d-flex align-items-center gap-2">
            <i class="bi bi-cart4" style="color:#5E83AE; font-size:1.8rem;"></i>
            Giỏ hàng
        </h2>

        <div class="checkout-steps">
            <a href="{{ route('cart.index') }}"
                class="checkout-steps__item {{ Request::routeIs('cart.index') ? 'active' : '' }}">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Giỏ hàng</span>
                    <em>Quản lý danh sách sản phẩm</em>
                </span>
            </a>
            <a href="{{ route('cart.checkout') }}"
                class="checkout-steps__item {{ Request::routeIs('cart.checkout') ? 'active' : '' }}">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Giao hàng và Thanh toán</span>
                    <em>Tiến hành thanh toán các sản phẩm</em>
                </span>
            </a>
            <a href="{{ route('cart.confirm') }}"
                class="checkout-steps__item {{ Request::routeIs('cart.confirm') ? 'active' : '' }}">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Xác nhận</span>
                    <em>Kiểm tra và gửi đơn hàng</em>
                </span>
            </a>
        </div>
        @yield('cart_content')
    </section>
</main>
@endsection