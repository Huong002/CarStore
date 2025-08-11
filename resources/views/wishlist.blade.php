@extends('layouts.app')
@section('content')

<main class="pt-90">
   <div class="mb-4 pb-4"></div>
   <section class="my-account container">
      <h2 class="page-title">Yêu thích</h2>
      <div class="row">
         <div class="col-lg-3">
            <ul class="account-nav">
               <li><a href="{{route('accountOrder.index')}}" class="menu-link menu-link_us-s">Lịch sử</a></li>
               <li><a href="{{route('accountDetail.index')}}" class="menu-link menu-link_us-s">Tài khoản</a></li>
               <li><a href="{{route('wishlist.index')}}" class="menu-link menu-link_us-s">Yêu thích</a></li>
               <li><a href="login.html" class="menu-link menu-link_us-s">Đăng xuất</a></li>
            </ul>
         </div>
         <div class="col-lg-9">
            <div class="page-content my-account__wishlist">
               <div class="products-grid row row-cols-2 row-cols-lg-3" id="products-grid">
                  <!-- Template sản phẩm -->
                  <div id="product-template" style="display: none;">
                     <div class="product-card-wrapper">
                        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                           <div class="pc__img-wrapper">
                              <div class="swiper-container background-img js-swiper-slider"
                                 data-settings='{"resizeObserver": true}'>
                                 <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                       <a href="" class="product-detail-link">
                                          <img loading="lazy" src="" width="330" height="400" alt="" class="pc__img product-image">
                                       </a>
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
                              <button class="btn-remove-from-wishlist" data-product-id="">
                                 <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_close" />
                                 </svg>
                              </button>
                           </div>

                           <div class="pc__info position-relative">
                              <a href="" class="product-detail-link text-decoration-none text-body">
                                 <p class="pc__category product-category"></p>
                                 <h6 class="pc__title product-name"></h6>
                                 <div class="product-card__price d-flex">
                                    <span class="money price product-price"></span>
                                 </div>
                              </a>

                              <a href="" class="product-link d-block">
                                 <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist" data-product-id="">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <use href="#icon_heart" />
                                    </svg>
                                 </button>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Thông báo không có sản phẩm yêu thích -->
                  <div id="empty-wishlist" class="col-12 text-center py-5" style="display: none;">
                     <div class="mb-3">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="#ccc">
                           <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                     </div>
                     <h5>Không có sản phẩm yêu thích</h5>
                     <p>Hãy thêm sản phẩm vào danh sách yêu thích của bạn</p>
                     <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
                  </div>

                  <!-- Danh sách sản phẩm sẽ được render bởi JavaScript -->
               </div>
            </div>
         </div>
      </div>
   </section>
</main>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      const productsGrid = document.getElementById('products-grid');
      const template = document.getElementById('product-template').innerHTML;
      const emptyWishlist = document.getElementById('empty-wishlist');

      // Lấy danh sách sản phẩm yêu thích từ localStorage
      let wishlistItems;
      try {
         wishlistItems = JSON.parse(localStorage.getItem('wishlist')) || [];
      } catch (e) {
         wishlistItems = [];
      }

      // Lọc các item không hợp lệ
      wishlistItems = wishlistItems.filter(item => item && item.id && item.name);

      // Hiển thị thông báo nếu không có sản phẩm
      if (wishlistItems.length === 0) {
         emptyWishlist.style.display = 'block';
         return;
      }

      // Render từng sản phẩm
      wishlistItems.forEach(product => {
         // Tạo một phần tử div mới để chứa HTML từ template
         const tempDiv = document.createElement('div');
         tempDiv.innerHTML = template;
         const productCard = tempDiv.querySelector('.product-card-wrapper');

         // Cập nhật thông tin sản phẩm
         const productImage = productCard.querySelector('.product-image');
         const productName = productCard.querySelector('.product-name');
         const productCategory = productCard.querySelector('.product-category');
         const productPrice = productCard.querySelector('.product-price');
         const removeButton = productCard.querySelector('.btn-remove-from-wishlist');
         const heartButton = productCard.querySelector('.js-add-wishlist');
         const productLink = productCard.querySelector('.product-link');

         // Gán dữ liệu
         productImage.src = product.image || '/assets/images/no-image.png';
         productImage.alt = product.name;
         productName.textContent = product.name;
         productCategory.textContent = product.category || 'Sản phẩm';
         productPrice.textContent = product.price || '';
         removeButton.setAttribute('data-product-id', product.id);
         heartButton.setAttribute('data-product-id', product.id);

         // Cập nhật đường dẫn sản phẩm với định dạng đúng
         // Ưu tiên sử dụng slug nếu có, nếu không thì tạo slug từ tên
         let productSlug;
         if (product.slug) {
            productSlug = product.slug;
         } else if (product.name) {
            // Tạo slug từ tên sản phẩm: chuyển thành chữ thường, thay thế dấu cách bằng dấu gạch ngang
            productSlug = product.name.toLowerCase()
               .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
               .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
               .replace(/[ìíịỉĩ]/g, 'i')
               .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
               .replace(/[ùúụủũưừứựửữ]/g, 'u')
               .replace(/[ỳýỵỷỹ]/g, 'y')
               .replace(/đ/g, 'd')
               .replace(/[^a-z0-9\s-]/g, '') // Loại bỏ ký tự đặc biệt
               .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
               .replace(/-+/g, '-'); // Loại bỏ dấu gạch ngang liên tiếp

            // Thêm ID vào cuối để đảm bảo tính duy nhất
            if (productSlug) {
               productSlug += `-${product.id}`;
            } else {
               productSlug = `product-${product.id}`;
            }
         } else {
            productSlug = `product-${product.id}`;
         }

         // Cập nhật tất cả các liên kết đến trang chi tiết sản phẩm
         productLink.href = `/shop/${productSlug}`;

         // Cập nhật tất cả các liên kết có class product-detail-link
         const detailLinks = productCard.querySelectorAll('.product-detail-link');
         detailLinks.forEach(link => {
            link.href = `/shop/${productSlug}`;
         });

         // Đặt nút trái tim là active
         heartButton.classList.add('active', 'icon-heart-active');
         const svg = heartButton.querySelector('svg');
         if (svg) svg.style.fill = 'red';

         // Thêm vào grid
         productsGrid.appendChild(productCard);
      });

      // Xử lý sự kiện xóa sản phẩm
      document.addEventListener('click', function(e) {
         const removeButton = e.target.closest('.btn-remove-from-wishlist');
         if (!removeButton) return;

         const productId = removeButton.getAttribute('data-product-id');
         if (!productId) return;

         // Xóa sản phẩm khỏi localStorage
         let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
         wishlist = wishlist.filter(item => item.id !== productId);
         localStorage.setItem('wishlist', JSON.stringify(wishlist));

         // Xóa card sản phẩm khỏi DOM
         const productCard = removeButton.closest('.product-card-wrapper');
         if (productCard) {
            productCard.remove();
         }

         // Cập nhật trạng thái của các nút trái tim khác
         document.querySelectorAll(`.js-add-wishlist[data-product-id="${productId}"]`).forEach(btn => {
            btn.classList.remove('active', 'icon-heart-active');
            const svg = btn.querySelector('svg');
            if (svg) svg.style.fill = '';
         });

         // Kiểm tra nếu không còn sản phẩm nào
         if (wishlist.length === 0) {
            emptyWishlist.style.display = 'block';
         }
      });
   });
</script>

@endsection