@extends('layouts.admin')
@section('content')
<style>
   .form-select,
   .form-control {
      height: 50px;
      border-radius: 12px;
      font-size: 14px;
      border: 1px solid #dee2e6;
   }

   .ck.ck-editor {
      width: 100% !important;
      margin-bottom: 1rem;
   }

   .ck-editor__editable {
      min-height: 200px;
   }

   /* Style cho form group */
   .form-group {
      margin-bottom: 1rem;
   }

   .form-label {
      font-weight: 500;
      margin-bottom: 0.5rem;
   }
</style>
<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Sửa thông báo</h3>
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
               <div class="text-tiny">Sửa thông báo</div>
            </li>
         </ul>
      </div>
      <!-- new-category -->
      <div class="wg-box">
         <form class="form-new-product form-style-1" action="{{route('admin.notification.update')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $notification->id }}" />
            <fieldset class="name">
               <div class="body-title">Tiêu đề thông báo <span class="tf-color-1">*</span></div>
               <input class="flex-grow" type="text" placeholder="Tiêu đề thông báo" name="name"
                  tabindex="0" value="{{ $notification->name }}" aria-required="true" required="">
            </fieldset>
            @error('name')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <fieldset class="name">
               <div class="body-title">Nội dung <span class="tf-color-1">*</span></div>
               <textarea class="flex-grow" placeholder="Nội dung thông báo" name="content"
                  tabindex="0" aria-required="true" required="" id="editor">{{ $notification->content }}</textarea>
            </fieldset>

            @error('content')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <fieldset class="name">
               <div class="body-title">Loại thông báo <span class="tf-color-1">*</span></div>
               <select class="form-select flex-grow" name="type">
                  <option value="all" {{ $notification->type == 'all' ? 'selected' : '' }}>Tất cả người dùng</option>
                  <option value="admin" {{ $notification->type == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                  <option value="customer" {{ $notification->type == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                  <option value="employee" {{ $notification->type == 'employee' ? 'selected' : '' }}>Nhân viên</option>
               </select>
            </fieldset>
            @error('type')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <div class="bot">
               <div></div>
               <button class="tf-button w208" type="submit">Sửa thông báo</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
   ClassicEditor
      .create(document.querySelector('#editor'), {
         toolbar: [
            'undo', 'redo', '|',
            'heading', '|',
            'bold', 'italic', 'underline', 'link', '|',
            'bulletedList', 'numberedList', '|',
            'insertTable', 'blockQuote', 'codeBlock'
         ],
         table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
         }
      })
      .catch(error => {
         console.error(error);
      });
</script>


@endsection