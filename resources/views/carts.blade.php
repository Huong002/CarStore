

@extends('layouts.app')
@section('content')
<main class="pt-90">
   <section class="shop-checkout container">
      <h2 class="page-title">Cart</h2>
      <div class="checkout-steps">
         <a href="{{ route('cart.index') }}" class="checkout-steps__item {{ Request::routeIs('cart.index') ? 'active' : '' }}">
            <span class="checkout-steps__item-number">01</span>
            <span class="checkout-steps__item-title">
               <span>Shopping Bag</span>
               <em>Manage Your Items List</em>
            </span>
         </a>
         <a href="{{ route('cart.checkout') }}" class="checkout-steps__item {{ Request::routeIs('cart.checkout') ? 'active' : '' }}">
            <span class="checkout-steps__item-number">02</span>
            <span class="checkout-steps__item-title">
               <span>Shipping and Checkout</span>
               <em>Checkout Your Items List</em>
            </span>
         </a>
         <a href="{{ route('cart.confirm') }}" class="checkout-steps__item {{ Request::routeIs('cart.confirm') ? 'active' : '' }}">
            <span class="checkout-steps__item-number">03</span>
            <span class="checkout-steps__item-title">
               <span>Confirmation</span>
               <em>Review And Submit Your Order</em>
            </span>
         </a>
      </div>
      @yield('cart_content')
   </section>
</main>
@endsection