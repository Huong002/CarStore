@extends('layouts.admin')
@section('content')
<style>
   .form-select,
   .form-control {
      height: 50px;
      border-radius: 12px;
      font-size: 14px; 
   }
</style>
<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Thêm thông báo</h3>
         <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
               <a href="{{route('admin.index')}}">
                  <div class="text-tiny">Dashboard</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <a href="{{route('admin.notifications')}}">
                  <div class="text-tiny">Thông báo</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Thêm thông báo mới</div>
            </li>
         </ul>
      </div>
      <!-- new-category -->
      <div class="wg-box">
         <form class="form-new-product form-style-1" action="{{route('admin.notification.store')}}" method="POST">
            @csrf
            <fieldset class="name">
               <div class="body-title">Tiêu đề thông báo <span class="tf-color-1">*</span></div>
               <input class="flex-grow" type="text" placeholder="Tiêu đề thông báo" name="name"
                  tabindex="0" value="{{old('name')}}" aria-required="true" required="">
            </fieldset>
            @error('name')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <fieldset class="name">
               <div class="body-title">Nội dung <span class="tf-color-1">*</span></div>
               <textarea class="flex-grow" rows="5" placeholder="Nội dung thông báo" name="content"
                  tabindex="0" aria-required="true" required="">{{old('content')}}</textarea>
            </fieldset>
            @error('content')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <fieldset class="name">
               <div class="body-title ">Loại thông báo<span class="tf-color-1">*</span></div>
               <select class="form-select flex-grow" name="type">
                  <option value="all">Tất cả người dùng</option>
                  <option value="admin">Quản trị viên</option>
                  <option value="customer">Khách hàng</option>
                  <option value="employee">Nhân viên</option>
               </select>
            </fieldset>
            @error('type')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <div class="bot">
               <div></div>
               <button class="tf-button w208" type="submit">Lưu thông báo</button>
            </div>
         </form>
      </div>
   </div>
</div>




@endsection


@push('scripts')
<script>
   $(function() {
      // Thêm xử lý khi cần thiết
   });
</script>
@endpush