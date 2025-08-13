<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="surfside media" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css')}}" />
  <link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('css/bootstrap-select.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}" />
  <link rel="stylesheet" href="{{ asset('font/fonts.css')}}" />
  <link rel="stylesheet" href="{{asset('icon/style.css')}}" />
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico')}}" />
  <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css')}}" />
  <!-- Thêm vào phần <head> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/avatar.css')}}" />

  @yield('styles')

  @stack("styles")
</head>

<style>
  /* Logo styles */
  #logo_header {
    max-width: 150px !important;
    max-height: 50px !important;
    width: auto !important;
    height: auto !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }

  .box-logo {
    display: flex !important;
    align-items: center !important;
    visibility: visible !important;
    opacity: 1 !important;
  }

  #site-logo-inner {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }

  /* Đảm bảo menu không ẩn logo */
  .layout-wrap.full-width .section-menu-left {
    display: block !important;
  }

  .layout-wrap.full-width .box-logo {
    display: flex !important;
  }

  .modal-content {
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
    font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Helvetica Neue", sans-serif;
  }

  .modal-header {
    border-bottom: 1px solid #e5e5e5;
    padding: 16px 24px;
    background-color: #f9f9f9;
  }

  .modal-title {
    font-size: 18px;
    font-weight: 500;
    color: #1d1d1f;
  }

  .btn-close {
    font-size: 1.2rem;
    opacity: 0.5;
  }

  .btn-edit {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #007aff;
    cursor: pointer;
    padding: 0;
    margin-left: auto;
    display: flex;
    align-items: center;
  }

  .btn-edit:hover {
    color: #005bb5;
  }

  .icon-edit:before {
    content: "\270E";
    font-family: Arial, sans-serif;
  }

  .modal-body {
    padding: 24px;
  }

  .avatar {
    border: 2px solid #e5e5e5;
    border-radius: 50% !important;
    object-fit: cover !important;
    width: 40px !important;
    height: 40px !important;
    aspect-ratio: 1/1 !important;
    display: inline-block;
    overflow: hidden !important;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .info-item {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
  }

  .info-label {
    font-weight: 500;
    color: #6e6e73;
    width: 80px;
    margin-right: 16px;
  }

  .info-value {
    font-size: 15px;
    color: #1d1d1f;
    flex-grow: 1;
  }

  .edit-field {
    border: 1px solid #d2d2d7;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 15px;
    color: #1d1d1f;
    background-color: #fff;
  }

  .edit-field:focus {
    border-color: #007aff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 122, 255, 0.2);
  }

  .modal-footer {
    border-top: 1px solid #e5e5e5;
    padding: 16px 24px;
    justify-content: flex-end;
  }

  .btn-primary {
    background-color: #007aff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 15px;
    color: #fff;
  }

  .btn-primary:hover {
    background-color: #005bb5;
  }

  .btn-secondary {
    background-color: #f9f9f9;
    border: 1px solid #d2d2d7;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 15px;
    color: #1d1d1f;
  }

  .btn-secondary:hover {
    background-color: #e5e5e5;
  }

  .modal-content {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(148, 163, 184, 0.2);
  }

  .text-cool-gray {
    color: #64748b;
  }

  .bg-cool {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
  }

  .logout-confirm-text {
    font-size: 22px !important;
    font-weight: 500;
  }

  .w-120px {
    min-width: 120px;
  }
</style>



<body class="body">
  <div id="wrapper">
    <div id="page" class="">
      <div class="layout-wrap">


        <div class="section-menu-left" style="background-color: seashell">
          <div class="box-logo">
            <a href="{{route('admin.index')}}" id="site-logo-inner">
              <img
                class=""
                id="logo_header"
                alt=""
                src="{{ asset('images/logo/logo.png') }}"
                data-light="{{ asset('images/logo/logo.png') }}"
                data-dark="{{ asset('images/logo/logo.png') }}" />
            </a>
            <div class="button-show-hide">
              <i class="icon-menu-left"></i>
            </div>
          </div>
          <div class="center">
            <div class="center-item">
              <div class="center-heading">NHÀ CHÍNH</div>
              <ul class="menu-list">
                <li class="menu-item">
                  <a href="{{route('admin.index')}}" class="">
                    <div class="icon"><i class="icon-grid"></i></div>
                    <div class="text">Dashboard</div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="center-item">
              <ul class="menu-list">
                <li class="menu-item has-children">
                  <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-shopping-cart"></i></div>
                    <div class="text">Sản phẩm</div>
                  </a>
                  <ul class="sub-menu">
                    <li class="sub-menu-item">
                      <a href="{{route('admin.product.add')}}" class="">
                        <div class="text">Thêm sản phẩm</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.products')}}" class="">
                        <div class="text">Sản phẩm</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.product.history')}}" class="">
                        <div class="text">Thùng rác</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="menu-item has-children">
                  <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-layers"></i></div>
                    <div class="text">Thương hiệu</div>
                  </a>
                  <ul class="sub-menu">
                    <li class="sub-menu-item">
                      <a href="{{route('admin.brand.add')}}" class="">
                        <div class="text">Thương hiệu mới</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.brands')}}" class="">
                        <div class="text">Thương hiệu</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.brand.history')}}" class="">
                        <div class="text">Thùng rác</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="menu-item has-children">
                  <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-layers"></i></div>
                    <div class="text">Danh mục</div>
                  </a>
                  <ul class="sub-menu">
                    <li class="sub-menu-item">
                      <a href="{{route('admin.category.add')}}" class="">
                        <div class="text">Danh mục mới</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.categories')}}" class="">
                        <div class="text">Danh mục</div>
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="menu-item has-children">
                  <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-file-plus"></i></div>
                    <div class="text">Hóa đơn</div>
                  </a>
                  <ul class="sub-menu">
                    <li class="sub-menu-item">
                      <a href="{{route('admin.orders')}}" class="">
                        <div class="text">Danh sách</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="menu-item has-children">
                  <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-bell"></i></div>
                    <div class="text">Thông báo</div>
                  </a>
                  <ul class="sub-menu">
                    <li class="sub-menu-item">
                      <a href="{{route('admin.notification.add')}}" class="">
                        <div class="text">Thêm mới</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.notifications')}}" class="">
                        <div class="text">Danh sách</div>
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="menu-item has-children">
                  <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-book"></i></div>
                    <div class="text">Blog</div>
                  </a>
                  <ul class="sub-menu">
                    <li class="sub-menu-item">
                      <a href="{{route('admin.blogs.add')}}" class="">
                        <div class="text">Thêm mới</div>
                      </a>
                    </li>
                    <li class="sub-menu-item">
                      <a href="{{route('admin.blogs')}}" class="">
                        <div class="text">Danh sách</div>
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- <li class="menu-item">
                  <a href="slider.html" class="">
                    <div class="icon"><i class="icon-image"></i></div>
                    <div class="text">Slider</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="coupons.html" class="">
                    <div class="icon"><i class="icon-grid"></i></div>
                    <div class="text">Coupns</div>
                  </a>
                </li> -->
                <!-- <li class="menu-item">
                  <a href="{{route('admin.inbox')}}" class="">
                    <div class="icon"><i class="bi bi-envelope"></i></div>
                    <div class="text">Hộp thư</div>
                  </a>
                </li> -->
                @if(Auth::user()->utype == 'ADM')
                <li class="menu-item">
                  <a href="{{route('admin.users')}}" class="">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="text">Tài khoản</div>
                  </a>
                </li>
                @endif
                <!-- <li class="menu-item"> -->
                <!-- <a href="{{route('admin.notifications')}}" class="">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="text">Thông báo</div>
                  </a>
                </li> -->

                <li class="menu-item">
                  <a href="{{route('admin.setting')}}" class="">
                    <div class="icon"><i class="icon-settings"></i></div>
                    <div class="text">Cài đặt</div>
                  </a>
                </li>
                <li class="menu-item">
                  <form action="{{ route('logout') }}" method="POST" style="display: contents;" class="logout-form">
                    @csrf
                    <a href="#" class="menu-item-button show-logout-modal">
                      <div class="icon"><i class="icon-log-out"></i></div>
                      <div class="text">Đăng xuất</div>
                    </a>
                  </form>
                </li>

              </ul>
            </div>
          </div>

        </div>
        <div class="section-content-right">
          <div class="header-dashboard">
            <div class="wrap">
              <div class="header-left">
                <a href="index-2.html">
                  <img
                    class=""
                    id="logo_header_mobile"
                    alt=""
                    src="{{asset('images/logo/logo.png')}}"
                    data-light="{{asset('images/logo/logo.png')}}"
                    data-dark="{{asset('images/logo/logo.png')}}"
                    data-width="154px"
                    data-height="52px"
                    data-retina="{{asset('images/logo/logo.png')}}" />
                </a>
                <div class="button-show-hide">
                  <i class="icon-menu-left"></i>
                </div>


              </div>
              <div class="header-grid">
                <div class="popup-wrap message type-header">
                  <div class="dropdown">
                    <button
                      class="btn btn-secondary dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton2"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <span class="header-item">
                        <span class="text-tiny">{{ $notifications->count() }}</span>
                        <i class="icon-bell"></i>
                      </span>
                    </button>
                    <ul
                      class="dropdown-menu dropdown-menu-end has-content"
                      aria-labelledby="dropdownMenuButton2">
                      <li>
                        <h6>Thông báo</h6>
                      </li>
                      @forelse($notifications as $noti)
                      <li>
                        <div class="message-item">
                          <div class="image">
                            <i class="icon-noti-{{ $loop->iteration }}"></i>
                          </div>
                          <div>
                            <div class="body-title-2">{{ $noti->name }}</div>
                            <div class="text-tiny">
                              {{ \Illuminate\Support\Str::limit(strip_tags($noti->content), 40, '...') }}
                            </div>
                            <div class="text-tiny text-muted">
                              {{ $noti->created_at->format('d/m/Y H:i') }}
                            </div>
                          </div>
                        </div>
                      </li>
                      @empty
                      <li>
                        <div class="message-item">
                          <div class="body-title-2">Không có thông báo mới</div>
                        </div>
                      </li>
                      @endforelse
                      <li>
                        <a href="{{ route('admin.notification.user') }}" class="tf-button w-full">
                          Xem toàn bộ
                        </a>

                      </li>
                    </ul>
                  </div>
                </div>

                <div class="popup-wrap user type-header">
                  <div class="dropdown">
                    <button
                      class="btn btn-secondary dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton3"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <span class="header-user wg-user">
                        <span class="user-avatar-container">
                          <img src="{{ Auth::user()->image ? asset('images/avatar/' . Auth::user()->image) : asset('images/avatar/user-1.png') }}"
                            alt="Avatar" class="user-avatar">
                        </span>
                        <span class="flex flex-column">
                          <span class="body-title mb-2">{{ Auth::user()->name }}</span>

                          <span class="text-tiny">{{ Auth::user()->utype }}</span>
                        </span>
                      </span>
                    </button>
                    <ul
                      class="dropdown-menu dropdown-menu-end has-content"
                      aria-labelledby="dropdownMenuButton3">
                      <li>
                        <a href="#" class="user-item" data-bs-toggle="modal" data-bs-target="#accountModal">
                          <div class="icon">
                            <i class="icon-user"></i>
                          </div>
                          <div class="body-title-2">Tài khoản</div>
                        </a>
                      </li>
                      <!-- <li>
                        <a href="{{('admin.inbox')}}" class="user-item">
                          <div class="icon">
                            <i class="icon-mail"></i>
                          </div>
                          <div class="body-title-2">Inbox</div>
                          <div class="number">27</div>
                        </a>
                      </li> -->
                      <!--
                      <li>
                        <a href="#" class="user-item">
                          <div class="icon">
                            <i class="icon-headphones"></i>
                          </div>
                          <div class="body-title-2">Support</div>
                        </a>
                      </li> -->
                      <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;" class="logout-form">
                          @csrf
                          <button type="button" class="user-item show-logout-modal" style="background: none; border: none; padding: 0;">
                            <div class="icon">
                              <i class="icon-log-out"></i>
                            </div>
                            <div class="body-title-2">Đăng xuất</div>
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="main-content">
            @yield('content')

            <div class="bottom-page">
              <div class="body-text">Copyright © 2024 HTAutoStore</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
  <script src="{{asset('js/sweetalert.min.js')}}"></script>
  <script src="{{asset('js/apexcharts/apexcharts.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>

  <script>
    // Fix logo path và vô hiệu hóa retinaLogos function
    $(document).ready(function() {
      // Đảm bảo logo path đúng
      $('#logo_header').attr('src', '{{ asset("images/logo/logo.png") }}');

      // Vô hiệu hóa retinaLogos function
      window.retinaLogos = function() {
        // Do nothing - prevent logo path change
      };

      // Đảm bảo logo luôn hiển thị
      $('#logo_header, .box-logo, #site-logo-inner').css({
        'display': 'block !important',
        'visibility': 'visible !important',
        'opacity': '1 !important'
      });

      // Xử lý đăng xuất với modal
      $('.show-logout-modal').on('click', function(e) {
        e.preventDefault();
        $('#logoutModal').modal('show');
        // Lưu form để submit sau
        window.currentLogoutForm = $(this).closest('form.logout-form');
      });

      // Xử lý nút xác nhận trong modal
      $('#confirmLogout').on('click', function() {
        if (window.currentLogoutForm) {
          window.currentLogoutForm.submit();
        }
        $('#logoutModal').modal('hide');
      });
    });
  </script>

  @stack("scripts")

  @include('admin.account')

  <!-- Force CSS reload to avoid cache -->
  <script>
    // Force CSS reload to avoid cache
    var link = document.createElement("link");
    link.href = "/css/avatar.css?v=" + Date.now();
    link.type = "text/css";
    link.rel = "stylesheet";
    document.getElementsByTagName("head")[0].appendChild(link);
  </script>

  <!-- Chatbot Component -->
  @include('components.chatbot-floating')

  <!-- Toast Component -->
  @include('components.toast-new')

  <!-- Modal xác nhận đăng xuất -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <!-- Header tối giản -->
        <div class="modal-header border-0 pb-2 bg-cool">
          <h6 class="modal-title fw-medium text-dark mb-0" id="logoutModalLabel">
            Xác nhận đăng xuất
          </h6>
          <button type="button" class="btn-close opacity-50" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>

        <!-- Body clean -->
        <div class="modal-body text-center py-4 bg-white">
          <p class="text-cool-gray mb-0 fs-4 fw-normal logout-confirm-text">
            Bạn có chắc chắn muốn đăng xuất?
          </p>
        </div>

        <!-- Footer minimal -->
        <div class="modal-footer border-0 pt-0 pb-4 bg-white justify-content-center">
          <button type="button" class="btn btn-light text-cool-gray px-4 fw-semibold py-2 w-120px me-2" data-bs-dismiss="modal">
            Hủy
          </button>
          <button type="button" class="btn btn-primary px-4 fw-semibold py-2 w-120px" id="confirmLogout">
            Đăng xuất
          </button>

        </div>
      </div>
    </div>
  </div>
</body>



</html>