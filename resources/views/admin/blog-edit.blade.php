@extends('layouts.admin')
@section('content')
@push('styles')
<style>
   .ck-editor__editable {
      min-height: 300px !important;
   }
</style>
@endpush


<!-- main-content-wrap -->
<div class="main-content-inner">
   <!-- main-content-wrap -->
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Chỉnh sửa blog</h3>
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
               <a href="{{route('admin.blogs')}}">
                  <div class="text-tiny">Blog</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Chỉnh sửa blog</div>
            </li>
         </ul>
      </div>
      <!-- form-add-product -->
      <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
         action="{{route('admin.blogs.update', $blog->id)}}">
         @csrf
         @method('PUT')
         <div class="wg-box">

            <fieldset class="name">
               <div class="body-title mb-10">Tiêu đề bài viết <span class="tf-color-1">*</span>
               </div>
               <input class="mb-10" type="text" placeholder="Nhập tiêu đề bài viết"
                  name="title" tabindex="0" value="{{old('title', $blog->title)}}" aria-required="true" required="">
               <div class="text-tiny">Tiêu đề không vượt quá 255 ký tự</div>
            </fieldset>
            @error('title')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <fieldset class="name">
               <div class="body-title mb-10">Đường dẫn (Slug) <span class="tf-color-1">*</span></div>
               <input class="mb-10" type="text" placeholder="Nhập đường dẫn"
                  name="slug" tabindex="0" value="{{old('slug', $blog->slug)}}" aria-required="true" required="">
               <div class="text-tiny">Đường dẫn không vượt quá 255 ký tự và phải là duy nhất</div>
            </fieldset>
            @error('slug')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <div class="gap22 cols">
               <fieldset class="category">
                  <div class="body-title mb-10">Danh mục <span class="tf-color-1">*</span>
                  </div>
                  <div class="select">
                     <select class="" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" {{old('category_id', $blog->category_id) == $category->id ? 'selected' : ''}}>
                           {{$category->name}}
                        </option>
                        @endforeach
                     </select>
                  </div>
               </fieldset>
               @error('category_id')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror

               <fieldset class="category">
                  <div class="body-title mb-10">Trạng thái <span class="tf-color-1">*</span>
                  </div>
                  <div class="select">
                     <select class="" name="status" required>
                        <option value="draft" {{old('status', $blog->status) == 'draft' ? 'selected' : ''}}>Bản nháp</option>
                        <option value="published" {{old('status', $blog->status) == 'published' ? 'selected' : ''}}>Xuất bản</option>
                     </select>
                  </div>
               </fieldset>
               @error('status')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
            </div>

            <fieldset class="description">
               <div class="body-title mb-10">Nội dung <span class="tf-color-1">*</span>
               </div>
               <textarea name="content" id="editor" rows="20" cols="80">
                  {!! old('content', $blog->content) !!}
               </textarea>
               <div class="text-tiny">Nội dung chi tiết của bài viết</div>
            </fieldset>
            @error('content')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
         </div>
         <div class="wg-box">
            <fieldset>
               <div class="body-title">Ảnh đại diện
               </div>
               <div class="upload-image flex-grow">
                  @if($blog->featured_image)
                  <div class="item" id="currentImage">
                     <img src="{{ asset('uploads/blogs/' . $blog->featured_image) }}" class="effect8" alt="Current featured image">
                     <p class="text-muted small">Ảnh hiện tại</p>
                  </div>
                  @endif
                  <div class="item" id="imgpreview" style="display:none">
                     <img src="" class="effect8" alt="">
                  </div>
                  <div id="upload-file" class="item up-load">
                     <label class="uploadfile" for="myFile">
                        <span class="icon">
                           <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">Thả ảnh ở đây hoặc <span
                              class="tf-color">chọn trong thiết bị</span></span>
                        <input type="file" id="myFile" name="featured_image" accept="image/*">
                     </label>
                  </div>
               </div>
               <div class="text-tiny">Để trống nếu không muốn thay đổi ảnh</div>
            </fieldset>
            @error('featured_image')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <div class="cols gap10">
               <button class="tf-button w-full" type="submit">Cập nhật bài viết</button>
            </div>
         </div>
      </form>
      <!-- /form-add-product -->
   </div>
   <!-- /main-content-wrap -->
</div>
<!-- /main-content-wrap -->



@endsection


@push('scripts')
<script>
   $(function() {
      // Preview hình ảnh chính khi chọn file
      $("#myFile").on("change", function(e) {
         const [file] = this.files;
         if (file) {
            $("#imgpreview img").attr("src", URL.createObjectURL(file));
            $("#imgpreview").show();
            $("#upload-file").hide();
            $("#currentImage").hide(); // Ẩn ảnh hiện tại khi chọn ảnh mới
         } else {
            $("#imgpreview").hide();
            $("#upload-file").show();
            $("#currentImage").show(); // Hiển thị lại ảnh hiện tại nếu không chọn ảnh mới
         }
      });

      // Preview bộ sưu tập ảnh
      $('#gFile').on("change", function(e) {
         const photoInp = $("#gFile");
         const gphotos = this.files;


         $.each(gphotos, function(key, val) {
            $('#galUpload').prepend('<div class="item gitems"><img src="' + URL.createObjectURL(val) + '" style="max-width: 100px; max-height: 100px;"></div>');
         });
      });

      // Tự động tạo slug từ tiêu đề bài viết (sử dụng input thay vì change để realtime)
      $("input[name='title']").on("input", function() {
         $("input[name='slug']").val(StringToSlug($(this).val()));
      });
   });

   function StringToSlug(Text) {
      return Text.toLowerCase()
         .replace(/[^\w ]+/g, '')
         .replace(/ +/g, '-');
   }
</script>
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
@endpush