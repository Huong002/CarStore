@extends('layouts.admin')
@section('content')


<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Danh sách sản phẩm đã xóa</h3>
         <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
               <a href="index.html">
                  <div class="text-tiny">Dashboard</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Danh sách sản phẩm đã xóa</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <form class="form-search">
                  <fieldset class="name">
                     <input type="text" placeholder="Tìm kiếm..." class="" name="name"
                        tabindex="2" value="" aria-required="true" required="">
                  </fieldset>
                  <div class="button-submit">
                     <button class="" type="submit"><i class="icon-search"></i></button>
                  </div>
               </form>
            </div>
            <a class="tf-button style-1 w208" href="{{route('admin.product.add')}}"><i
                  class="icon-plus"></i>Thêm mới</a>
         </div>
         <div class="table-responsive">
            <table class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th class="text-center" style="white-space: norwap;">STT</th>
                     <th class="text-center" style="white-space: norwap;">Tên sản phẩm</th>
                     <th class="text-center" style="white-space: norwap;">Giá</th>
                     <th class="text-center" style="white-space: norwap;">Giá khuyến mãi</th>
                     <th class="text-center" style="white-space: norwap;">SKU</th>
                     <th class="text-center" style="white-space: norwap;">Danh mục</th>
                     <!-- <th class="text-center" style="white-space: norwap;">Thương hiệu</th> -->
                     <!-- <th class="text-center" style="white-space: norwap;">Nổi bật</th> -->
                     <th class="text-center" style="white-space: norwap;">Tình trạng</th>
                     <th class="text-center" style="white-space: norwap;">Số lượng</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($products as $product)
                  <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td class="pname">
                        <div class="image">
                           @if($product->images && $product->images->count() > 0)
                           @php
                           $primaryImage = $product->images->where('is_primary', 1)->first();
                           $displayImage = $primaryImage ? $primaryImage : $product->images->first();
                           @endphp
                           <img src="{{asset('uploads/products/'.$displayImage->imageName)}}" alt="{{$product->name}}" class="image" style="width: 50px; height: 50px; object-fit: cover;">
                           @else
                           <img src="{{asset('uploads/products/default.jpg')}}" alt="{{$product->name}}" class="image" style="width: 50px; height: 50px; object-fit: cover;">
                           @endif
                        </div>
                        <div class="name">
                           <a href="#" class="body-title-2">{{$product->name}}</a>
                           <div class="text-tiny mt-3">{{$product->slug}}</div>
                        </div>
                     </td>
                     <td>{{number_format($product->regular_price)}} đ</td>
                     <td>{{number_format($product->sale_price)}} đ</td>
                     <td>{{$product->SKU}}</td>
                     <td>{{$product->category ? $product->category->name : 'N/A'}}</td>
                     <!-- <td>{{$product->brand ? $product->brand->name : 'N/A'}}</td> -->
                     <!-- <td>{{$product->featured == 1 ? "Có" : "Không"}}</td> -->
                     <td>
                        <span class="badge {{ $product->stock_status == 'instock' ? 'bg-success' : 'bg-danger' }}">
                           {{ $product->stock_status == 'instock' ? 'Còn hàng' : 'Hết hàng' }}
                        </span>
                     </td>
                     <td>{{$product->quantity}}</td>
                     <td>
                        <div class="list-icon-function">
                           <a href="#" target="_blank">
                              <div class="item eye">
                                 <i class="icon-eye"></i>
                              </div>
                           </a>
                           <form action="{{ route('admin.product.restore', ['id' => $product->id]) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('PATCH')
                              <button type="submit" class="item edit" style="border: none; background: none; padding: 0;">
                                 <i class="bi bi-arrow-repeat"></i>
                              </button>
                           </form>
                           <form action="{{route('admin.product.delete', ['id' => $product->id]) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="item text-danger delete" style="border: none; background: none; padding: 0;">
                                 <i class="icon-trash-2"></i>
                              </button>
                           </form>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>

         <div class="divider"></div>
         <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

            {{$products->links('pagination::bootstrap-5')}}

         </div>
      </div>
   </div>
</div>



@endsection


@push('scripts')
<script>
   $(function() {
      $('.delete').on('click', function(e) {
         e.preventDefault();
         var form = $(this).closest('form');
         swal({
            title: 'Bạn có chắn chắn muốn xóa sản phẩm?',
            text: 'Bạn muốn xóa hàng này?',
            icon: "warning",
            buttons: {
               cancel: "Không",
               confirm: {
                  text: "Có",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true
               }
            },
            dangerMode: true,
         }).then(function(result) {
            if (result) form.submit();
         });
      });
   });
</script>
@endpush