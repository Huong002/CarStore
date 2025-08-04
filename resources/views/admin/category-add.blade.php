@extends('layouts.admin')
@section('content')
<style>
   .form-select,
   .form-control {
      height: 40px;
      border-radius: 12px;
      font-size: 14px;
   }
</style>
<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Thêm mới danh mục</h3>
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
               <a href="{{route('admin.categories')}}">
                  <div class="text-tiny">Danh mục</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Danh mục mới</div>
            </li>
         </ul>
      </div>
      <!-- new-category -->
      <div class="wg-box">
         <form class="form-new-product form-style-1" action="{{route('admin.category.store')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <fieldset class="name">
               <div class="body-title">Danh mục cha<span class="tf-color-1">*</span></div>
               <select class="form-select flex-grow" name="parent_id">
                  <option value="">-- Không có danh mục cha --</option>
                  @foreach($parentCategories as $parent)
                  <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                  @endforeach
               </select>
            </fieldset>
            @error('name')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <fieldset class="name">
               <div class="body-title">Tên danh mục <span class="tf-color-1">*</span></div>
               <input class="flex-grow" type="text" placeholder="Tên danh mục" name="name"
                  tabindex="0" value="{{old('name')}}" aria-required="true" required="">
            </fieldset>
            @error('name')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <fieldset class="name">
               <div class="body-title">Tên đường dẫn <span class="tf-color-1">*</span></div>
               <input class="flex-grow" type="text" placeholder="Tên đường dẫn" name="slug"
                  tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
            </fieldset>
            @error('slug')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <fieldset>
               <div class="body-title">Tải ảnh <span class="tf-color-1">*</span>
               </div>
               <div class="upload-image flex-grow">
                  <div class="item" id="imgpreview" style="display:none">
                     <img src="upload-1.html" class="effect8" alt="">
                  </div>
                  <div id="upload-file" class="item up-load">
                     <label class="uploadfile" for="myFile">
                        <span class="icon">
                           <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">Thả ảnh tại đây hoặc <span
                              class="tf-color">chọn từ thiết bị</span></span>
                        <input type="file" id="myFile" name="image" accept="image/*">
                     </label>
                  </div>
               </div>
            </fieldset>
            @error('image')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <div class="bot">
               <div></div>
               <button class="tf-button w208" type="submit">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>




@endsection


@push('scripts')
<script>
   $(function() {
      $("#myFile").on("change", function(e) {
         const [file] = this.files;
         if (file) {
            $("#imgpreview img").attr("src", URL.createObjectURL(file));
            $("#imgpreview").show();
         }
      });

      $("input[name='name']").on("change", function() {
         $("input[name='slug']").val(StringToSlug($(this).val()));
      });
   });

   function StringToSlug(Text) {
      return Text.toLowerCase()
         .replace(/[^\w ]+/g, '')
         .replace(/ +/g, '-');
   }
</script>
@endpush