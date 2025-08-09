@extends('layouts.admin')
@section('content')


<style>
   .text-danger {
      font-size: initial;
      line-height: 36px;
   }

   .alert {
      font-size: initial;
   }
</style>

<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Cài đặt</h3>
         <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
               <a href="#">
                  <div class="text-tiny">Dashboard</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Cài đặt</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="col-lg-12">
            <div class="page-content my-account__edit">
               <div class="my-account__edit-form">
                  <form name="account_edit_form" action="{{ route('admin.settings.update') }}" method="POST"
                     class="form-new-product form-style-1 needs-validation"
                     novalidate="">
                     @csrf

                     <fieldset class="name">
                        <div class="body-title">Họ và tên <span class="tf-color-1">*</span>
                        </div>
                        <input class="flex-grow" type="text" placeholder="Nhập vào họ và tên"
                           name="name" tabindex="0" value="{{ old('name', $user->name ?? '') }}" aria-required="true"
                           required="">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </fieldset>

                     <fieldset class="name">
                        <div class="body-title">Số điện thoại <span
                              class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Số điện thoại"
                           name="mobile" tabindex="0" value="{{ old('mobile', $user->employee->phone ?? '') }}" aria-required="true"
                           required="">
                        @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </fieldset>

                     <fieldset class="name">
                        <div class="body-title">Email <span
                              class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="email" placeholder="Địa chỉ email"
                           name="email" tabindex="0" value="{{ old('email', $user->email ?? '') }}" aria-required="true"
                           required="">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </fieldset>

                     <div class="row">
                        <div class="col-md-12">
                           <div class="my-3">
                              <h5 class="text-uppercase mb-0">Đổi mật khẩu</h5>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <fieldset class="name">
                              <div class="body-title pb-3">Mật khẩu cũ <span
                                    class="tf-color-1">*</span>
                              </div>
                              <input class="flex-grow" type="password"
                                 placeholder="Mật khẩu cũ" id="old_password"
                                 name="old_password" aria-required="false">
                              @error('old_password')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </fieldset>

                        </div>
                        <div class="col-md-12">
                           <fieldset class="name">
                              <div class="body-title pb-3">Mật khẩu mới <span
                                    class="tf-color-1">*</span>
                              </div>
                              <input class="flex-grow" type="password"
                                 placeholder="Mật khẩu mới" id="new_password"
                                 name="new_password" aria-required="false">
                              @error('new_password')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </fieldset>

                        </div>
                        <div class="col-md-12">
                           <fieldset class="name">
                              <div class="body-title pb-3">Xác nhận mật khẩu mới <span
                                    class="tf-color-1">*</span></div>
                              <input class="flex-grow" type="password"
                                 placeholder="Xác nhận mật khẩu"
                                 id="new_password_confirmation"
                                 name="new_password_confirmation"
                                 aria-required="false">
                              @error('new_password_confirmation')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </fieldset>
                        </div>
                        <div class="col-md-12">
                           <div class="my-3">
                              <button type="submit"
                                 class="btn btn-primary tf-button w208">Cập nhập</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



@endsection