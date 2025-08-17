@extends('layouts.admin')
@section('content')


<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Danh sách sản phẩm</h3>
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
               <div class="text-tiny">Danh sách sản phẩm</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <form class="form-search">
                  <fieldset class="name">
                     <input type="text" placeholder="Tìm kiếm..." class="" name="name"
                        tabindex="2" value="{{request('name')}}" aria-required="true" required="">
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
                     <th class="text-center" style="white-space:nowrap;">STT</th>
                     <th style="min-width: 140px; text-align:left;">Tên sản phẩm</th>
                     <th class="text-center" style="min-width: 160px;">Giá</th>
                     <th class="text-center" style="min-width: 160px;">Giá khuyến mãi</th>
                     <th class="text-center" style="white-space:nowrap;">SKU</th>
                     <th class="text-center" style="white-space:nowrap;">Thương hiệu</th>
                     <th class="text-center" style="white-space:nowrap;">Kho</th>
                     <th class="text-center" style="white-space:nowrap;">Số lượng</th>
                     <th class="text-center" style="white-space:nowrap;"></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($products as $product)
                  <tr>
                     <td class="text-center" style="white-space:nowrap;">{{$loop->iteration}}</td>
                     <td class="pname" style="white-space:nowrap; text-align:left;">
                        <div class="image" style="display:inline-block;vertical-align:middle;">
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
                        <div class="name" style="display:inline-block;vertical-align:middle;">
                           <a href="#" class="body-title-2" style="text-align:left; display:block; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{$product->name}}">
                              {{ \Illuminate\Support\Str::limit($product->name, 20) }}
                           </a>
                           <div class="text-tiny mt-3" style="text-align:left; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{$product->slug}}">
                              {{ \Illuminate\Support\Str::limit($product->slug, 25) }}
                           </div>
                        </div>
                     </td>
                     <td class="text-center">{{number_format($product->regular_price)}} đ</td>
                     <td class="text-center">{{number_format($product->sale_price)}} đ</td>
                     <td class="text-center" style="white-space:nowrap;">{{$product->SKU}}</td>
                     <!-- <td class="text-center" style="white-space:nowrap;">{{$product->category ? $product->category->name : 'N/A'}}</td> -->
                     <td class="text-center" style="white-space:nowrap;">{{$product->brand ? $product->brand->name : 'N/A'}}</td>
                     <!-- <td class="text-center" style="white-space:nowrap;">{{$product->featured == 1 ? "Có" : "Không"}}</td> -->
                     <td class="text-center" style="white-space:nowrap;">
                        {!! $product->stock_status == 'instock'
                        ? '<span class="badge bg-success">Còn hàng</span>'
                        : '<span class="badge bg-danger">Hết hàng</span>' !!}
                     </td>

                     <td class="text-center" style="white-space:nowrap;">{{$product->quantity}}</td>
                     
                     <td class="text-center" style="white-space:nowrap;">
                        <div class="list-icon-function d-flex justify-content-center align-items-center gap-4">
                           <!-- <a href="#" target="_blank">
                              <div class="item eye">
                                 <i class="icon-eye"></i>
                              </div>
                           </a> -->
                           <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                              <div class="item edit">
                                 <i class="icon-edit-3"></i>
                              </div>
                           </a>
                           <form action="{{ route('admin.product.soft_delete', ['id' => $product->id]) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <div class="item text-danger delete">
                                 <i class="icon-trash-2"></i>
                              </div>
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