@extends('layouts.admin')
@section('content')


<!-- main-content-wrap -->
<div class="main-content-inner">
   <!-- main-content-wrap -->
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Thêm sản phẩm</h3>
         <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
               <a href="index-2.html">
                  <div class="text-tiny">Dashboard</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <a href="all-product.html">
                  <div class="text-tiny">Sản phẩm</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Thêm sản phẩm</div>
            </li>
         </ul>
      </div>
      <!-- form-add-product -->
      <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
         action="{{route('admin.product.store')}}">
         @csrf
         <div class="wg-box">

            <fieldset class="name">
               <div class="body-title mb-10">Tên sản phẩm <span class="tf-color-1">*</span>
               </div>
               <input class="mb-10" type="text" placeholder="Nhập tên sản phẩm"
                  name="name" tabindex="0" value="{{old('name')}}" aria-required="true" required="">
               <div class="text-tiny">Tên sản phẩm ko vượt quá 100 kí tự</div>
            </fieldset>
            @error('name')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror


            <fieldset class="name">
               <div class="body-title mb-10">Tên đường dẫn <span class="tf-color-1">*</span></div>
               <input class="mb-10" type="text" placeholder="Nhập tên sản phẩm"
                  name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
               <div class="text-tiny">Không vượt quá 100 kí tự</div>

            </fieldset>
            @error('slug')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <fieldset class="color">
               <div class="body-title mb-10">Màu sắc <span class="tf-color-1">*</span></div>
               <div class="select">
                  <select class="" name="color_id" required>
                     <option value="">Chọn màu sắc</option>
                     @foreach($colors as $color)
                     <option value="{{$color->id}}">{{$color->name}}</option>
                     @endforeach
                  </select>
               </div>
            </fieldset>
            @error('color_id')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
            <div class="gap22 cols">
               <fieldset class="category">
                  <div class="body-title mb-10">Danh mục <span class="tf-color-1">*</span>
                  </div>
                  <div class="select">
                     <select class="" name="category_id">
                        <option value="">Chọn danh mục</option>

                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </fieldset>
               @error('category_id')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
               <fieldset class="brand">
                  <div class="body-title mb-10">Thương hiệu <span class="tf-color-1">*</span>
                  </div>
                  <div class="select">
                     <select class="" name="brand_id">
                        <option value="">Chọn thương hiệu</option>

                        @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>

                        @endforeach
                     </select>
                  </div>
               </fieldset>
               @error('brand_id')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
            </div>

            <fieldset class="shortdescription">
               <div class="body-title mb-10">Mô tả ngắn <span
                     class="tf-color-1">*</span></div>
               <textarea class="mb-10 ht-150" name="short_description"
                  placeholder="Nhập mô tả ngắn" tabindex="0" aria-required="true"
                  required=""></textarea>
               <div class="text-tiny"></div>
            </fieldset>
            @error('short_description')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror

            <fieldset class="description">
               <div class="body-title mb-10">Mô tả <span class="tf-color-1">*</span>
               </div>
               <textarea class="mb-10" name="description" placeholder="Nhập mô tả"
                  tabindex="0" aria-required="true" required=""></textarea>
               <div class="text-tiny"></div>
            </fieldset>
            @error('description')
            <span class="alert alert-danger text-center">{{$message}}</span>
            @enderror
         </div>
         <div class="wg-box">
            <fieldset>
               <div class="body-title">Tải ảnh <span class="tf-color-1">*</span>
               </div>
               <div class="upload-image flex-grow">
                  <div class="item" id="imgpreview" style="display:none">
                     <img src="../../../localhost_8000/images/upload/upload-1.png"
                        class="effect8" alt="">
                  </div>
                  <div id="upload-file" class="item up-load">
                     <label class="uploadfile" for="myFile">
                        <span class="icon">
                           <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">Thả ảnh ở đây hoặc <span
                              class="tf-color">chọn trong thiết bị</span></span>
                        <input type="file" id="myFile" name="image" accept="image/*">
                     </label>
                  </div>
               </div>
            </fieldset>

            <fieldset>
               <div class="body-title mb-10">Tải bộ sưu tập ảnh</div>
               <div class="upload-image mb-16">
                  <!-- <div class="item">
         <img src="images/upload/upload-1.png" alt="">
      </div>                                                 -->
                  <div id="galUpload" class="item up-load">
                     <label class="uploadfile" for="gFile">
                        <span class="icon">
                           <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="text-tiny">Thả ảnh ở đây hoặc <span
                              class="tf-color">chọn trong thiết bị</span></span>
                        <input type="file" id="gFile" name="images[]" accept="image/*"
                           multiple="">
                     </label>
                  </div>
               </div>
            </fieldset>

            <div class="cols gap22">
               <fieldset class="name">
                  <div class="body-title mb-10">Giá <span
                        class="tf-color-1">*</span></div>
                  <input class="mb-10" type="text" placeholder="Hãy nhập giá"
                     name="regular_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true"
                     required="">
               </fieldset>
               @error('regular_price')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
               <fieldset class="name">
                  <div class="body-title mb-10">Giá khuyến mãi <span
                        class="tf-color-1">*</span></div>
                  <input class="mb-10" type="text" placeholder="Hãy nhập giá khuyến mãi"
                     name="sale_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true"
                     required="">
               </fieldset>
               @error('sale_price')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
            </div>


            <div class="cols gap22">
               <fieldset class="name">
                  <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                  </div>
                  <input class="mb-10" type="text" placeholder="Hãy nhập SKU" name="SKU"
                     tabindex="0" value="{{old('SKU')}}" aria-required="true" required="">
               </fieldset>
               @error('SKU')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
               <fieldset class="name">
                  <div class="body-title mb-10">Số lượng <span class="tf-color-1">*</span>
                  </div>
                  <input class="mb-10" type="text" placeholder="Hãy nhập số lượng"
                     name="quantity" tabindex="0" value="{{old('quantity')}}" aria-required="true"
                     required="">
               </fieldset>
            </div>

            <div class="cols gap22">
               <fieldset class="name">
                  <div class="body-title mb-10">Trạng thái</div>
                  <div class="select mb-10">
                     <select class="" name="stock_status">
                        <option value="instock">Còn hàng</option>
                        <option value="outofstock">Hết hàng</option>
                     </select>
                  </div>
               </fieldset>
               @error('stock_status')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
               <fieldset class="name">
                  <div class="body-title mb-10">Sản phẩm nổi bật</div>
                  <div class="select mb-10">
                     <select class="" name="featured">
                        <option value="0">Không</option>
                        <option value="1">Có</option>
                     </select>
                  </div>
               </fieldset>
               @error('featured')
               <span class="alert alert-danger text-center">{{$message}}</span>
               @enderror
            </div>
            <div class="cols gap10">
               <button class="tf-button w-full" type="submit">Thêm sản phẩm</button>
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
         } else {
            $("#imgpreview").hide();
            $("#upload-file").show();
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

      // Tự động tạo slug từ tên sản phẩm (sử dụng input thay vì change để realtime)
      $("input[name='name']").on("input", function() {
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