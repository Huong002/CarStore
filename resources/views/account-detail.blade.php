  @extends('layouts.app')
  @section('content')
  <style>
     /* Fix form-floating labels bị che khuất */
     .form-floating {
        position: relative;
     }

     .form-floating>.form-control {
        height: calc(3.5rem + 2px);
        line-height: 1.25;
        padding: 1rem 0.75rem;
     }

     .form-floating>label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1rem 0.75rem;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
        color: #6c757d;
        z-index: 2;
     }

     /* Khi input có giá trị hoặc đang focus */
     .form-floating>.form-control:focus~label,
     .form-floating>.form-control:not(:placeholder-shown)~label,
     .form-floating>.form-control.has-value~label {
        opacity: 0;
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        background-color: white;
        padding: 0.2rem 0.5rem;
        color: #0d6efd;
     }

     /* Đảm bảo label luôn hiển thị đúng cho input có value */
     .form-floating>.form-control[value]:not([value=""])~label {
        opacity: 0;
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        background-color: white;
        padding: 0.2rem 0.5rem;
        color: #6c757d;
     }

     .form-floating>.form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
     }

     /* Force label positioning for pre-filled inputs */
     .form-floating .form-control:not(:placeholder-shown),
     .form-floating .form-control:focus,
     .form-floating .form-control.has-value {
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
     }
  </style>

  <main class="pt-90">
     <div class="mb-4 pb-4"></div>
     <section class="my-account container">
        <h2 class="page-title">Tài khoản</h2>
        <div class="row">
           <div class="col-lg-3">
              <ul class="account-nav">
                 <li><a href="{{route('accountOrder.index')}}" class="menu-link menu-link_us-s">Lịch sử</a></li>
                 <li><a href="{{route('accountDetail.index')}}" class="menu-link menu-link_us-s">Tài khoản</a></li>
                 <li><a href="{{route('wishlist.index')}}" class="menu-link menu-link_us-s">Yêu thích</a></li>
              </ul>
           </div>
           <div class="col-lg-9">
              <div class="page-content my-account__edit">
                 <div class="my-account__edit-form">
                    <form name="account_edit_form" action="{{ route('user.update') }}" method="POST" class="needs-validation" novalidate="">
                       @csrf
                       @method('PUT')
                       @if(session('status'))
                       <div class="alert alert-success">{{ session('status') }}</div>
                       @endif
                       @if($errors->any())
                       <div class="alert alert-danger">
                          <ul class="mb-0">
                             @foreach($errors->all() as $error)
                             <li>{{ $error }}</li>
                             @endforeach
                          </ul>
                       </div>
                       @endif
                       <div class="row">
                          <div class="col-md-12">
                             <div class="form-floating my-3">
                                <input type="text" class="form-control" id="name" placeholder="Full Name" name="name" value="{{ $user->name ?? '' }}" required="">
                                <label for="name">Họ và tên</label>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="form-floating my-3">
                                <input type="text" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" value="{{ $customer->phone ?? '' }}"
                                   required="">
                                <label for="mobile">Số điện thoại</label>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="form-floating my-3">
                                <input type="email" class="form-control" id="account_email" placeholder="Email Address" name="email" value="{{ $user->email ?? '' }}"
                                   required="">
                                <label for="account_email">Email Address</label>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="my-3">
                                <h5 class="text-uppercase mb-0">Đổi mật khẩu</h5>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="form-floating my-3">
                                <input type="password" class="form-control" id="old_password" name="old_password"
                                   placeholder="Old password" required="">
                                <label for="old_password">Mật khẩu cũ</label>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="form-floating my-3">
                                <input type="password" class="form-control" id="account_new_password" name="new_password"
                                   placeholder="New password" required="">
                                <label for="account_new_password">Mật khẩu mới</label>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="form-floating my-3">
                                <input type="password" class="form-control" cfpwd="" data-cf-pwd="#new_password"
                                   id="new_password_confirmation" name="new_password_confirmation"
                                   placeholder="Confirm new password" required="">
                                <label for="new_password_confirmation">Xác nhận mật khẩu</label>
                                <div class="invalid-feedback">Mật khẩu không khớp</div>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <div class="my-3">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                             </div>
                          </div>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
     </section>
  </main>

  <script>
     // Đảm bảo labels hiển thị đúng cho các input đã có giá trị
     document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-floating .form-control');
        inputs.forEach(function(input) {
           if (input.value && input.value.trim() !== '') {
              input.classList.add('has-value');
           }

           // Lắng nghe sự kiện input để cập nhật class
           input.addEventListener('input', function() {
              if (this.value && this.value.trim() !== '') {
                 this.classList.add('has-value');
              } else {
                 this.classList.remove('has-value');
              }
           });
        });
     });
  </script>

  @endsection