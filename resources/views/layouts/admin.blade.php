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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/avatar.css')}}" />

  @yield('styles')

  @stack("styles")
</head>

<style>
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

                <li class="menu-item">
                  <a href="{{route('admin.users')}}" class="">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="text">Tài khoản</div>
                  </a>
                </li>
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
                  <a href="settings.html" class="">
                    <div class="icon"><i class="icon-log-out"></i></div>
                    <div class="text">Đăng xuất</div>
                  </a>
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
                    src="{{ asset('images/logo/logo.png') }}"
                    data-light="{{ asset('images/logo/logo.png') }}"
                    data-dark="{{ asset('images/logo/logo.png') }}"
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
                              {{ $noti->content }}
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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                          @csrf
                          <button type="submit" class="user-item" style="background: none; border: none; padding: 0;">
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
  @stack("scripts")

  @include('admin.account')

  // tao the link css buoc tirnh duyet tai lai css moi nhat ma khong dung cache
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
</body>

</html>