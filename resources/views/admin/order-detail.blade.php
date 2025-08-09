@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Chi tiết đơn hàng #{{$order->id}}</h3>
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
               <a href="{{route('admin.orders')}}">
                  <div class="text-tiny">Đơn hàng</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Chi tiết đơn hàng</div>
            </li>
         </ul>
      </div>

      <!-- Thông tin đơn hàng -->
      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <h5>Chi tiết sản phẩm trong đơn hàng</h5>
            </div>
            <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Trở về</a>
         </div>

         <div class="table-responsive">
            <table class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>Sản phẩm</th>
                     <th class="text-center">Giá</th>
                     <th class="text-center">Số lượng</th>
                     <th class="text-center">SKU</th>
                     <th class="text-center">Danh mục</th>
                     <th class="text-center">Thương hiệu</th>
                     <th class="text-center">Tổng tiền</th>
                     <!-- <th class="text-center">Thao tác</th> -->
                  </tr>
               </thead>
               <tbody>
                  @foreach($order->orderDetails as $detail)
                  <tr>
                     <td class="pname">
                        <div class="image">
                           @if($detail->product && $detail->product->images->where('is_primary', true)->first())
                           <img src="{{asset('uploads/products/'.$detail->product->images->where('is_primary', true)->first()->imageName)}}"
                              alt="{{$detail->product->name}}" class="image" style="width: 60px; height: 60px; object-fit: cover;">
                           @else
                           <img src="{{asset('assets/images/no-image.png')}}" alt="No Image" class="image" style="width: 60px; height: 60px; object-fit: cover;">
                           @endif
                        </div>
                        <div class="name">
                           @if($detail->product)
                           <a href="{{route('admin.product.edit', $detail->product->id)}}" target="_blank" class="body-title-2">
                              {{$detail->product->name}}
                           </a>
                           @else
                           <span class="text-muted">Sản phẩm đã bị xóa</span>
                           @endif
                        </div>
                     </td>
                     <td class="text-center">{{number_format($detail->price, 0, ',', '.')}} đ</td>
                     <td class="text-center">{{$detail->quantity}}</td>
                     <td class="text-center">
                        @if($detail->product)
                        {{$detail->product->SKU}}
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                     </td>
                     <td class="text-center">
                        @if($detail->product && $detail->product->category)
                        {{$detail->product->category->name}}
                        @else
                        <span class="text-muted">Không có</span>
                        @endif
                     </td>
                     <td class="text-center">
                        @if($detail->product && $detail->product->brand)
                        {{$detail->product->brand->name}}
                        @else
                        <span class="text-muted">Không có</span>
                        @endif
                     </td>
                     <td class="text-center"><strong>{{number_format($detail->total, 0, ',', '.')}} đ</strong></td>
                     <!-- <td class="text-center">
                        @if($detail->product)
                           <a href="{{route('admin.product.edit', $detail->product->id)}}" target="_blank">
                              <div class="list-icon-function view-icon">
                                 <div class="item eye">
                                    <i class="icon-eye"></i>
                                 </div>
                              </div>
                           </a>
                        @endif
                     </td> -->
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>

      <!-- Thông tin khách hàng -->
      <div class="wg-box mt-5">
         <h5>Thông tin khách hàng</h5>
         <div class="my-account__address-item col-md-6">
            <div class="my-account__address-item__detail">
               @if($order->customer)
               <p><strong>Tên:</strong> {{$order->customer->customerName}}</p>
               <p><strong>Email:</strong> {{$order->customer->email}}</p>
               <p><strong>Địa chỉ:</strong> {{$order->customer->address}}</p>
               <p><strong>Điện thoại:</strong> {{$order->customer->phone}}</p>
               <p><strong>Giới tính:</strong> {{$order->customer->gender}}</p>
               <p><strong>Ngày sinh:</strong> {{$order->customer->birthDay}}</p>
               @else
               <p class="text-muted">Thông tin khách hàng không có sẵn</p>
               @endif
            </div>
         </div>
      </div>

      <!-- Thông tin nhân viên xử lý -->
      <div class="wg-box mt-5">
         <h5>Thông tin nhân viên xử lý</h5>
         <div class="my-account__address-item col-md-6">
            <div class="my-account__address-item__detail">
               @if($order->employee)
               <p><strong>Tên nhân viên:</strong> {{$order->employee->name}}</p>
               <p><strong>Email:</strong> {{$order->employee->email}}</p>
               <p><strong>Điện thoại:</strong> {{$order->employee->phone}}</p>
               @else
               <p class="text-muted">Thông tin nhân viên không có sẵn</p>
               @endif
            </div>
         </div>
      </div>

      <!-- Thông tin giao dịch -->
      <div class="wg-box mt-5">
         <h5>Thông tin giao dịch</h5>
         <table class="table table-striped table-bordered table-transaction">
            <tbody>
               <tr>
                  <th>Tạm tính</th>
                  <td>{{number_format($order->total - $order->tax, 0, ',', '.')}} đ</td>
                  <th>Thuế</th>
                  <td>{{number_format($order->tax, 0, ',', '.')}} đ</td>
                  <th>Tổng số sản phẩm</th>
                  <td>{{$order->total_item}}</td>
               </tr>
               <tr>
                  <th>Tổng cộng</th>
                  <td><strong>{{number_format($order->total, 0, ',', '.')}} đ</strong></td>
                  <th>Trạng thái</th>
                  <td>
                     <span class="badge 
                        @if($order->status == 'pending') badge-warning
                        @elseif($order->status == 'processing') badge-info
                        @elseif($order->status == 'shipped') badge-primary
                        @elseif($order->status == 'delivered') badge-success
                        @else badge-danger
                        @endif">
                        {{ucfirst($order->status)}}
                     </span>
                  </td>
                  <th>Ngày tạo</th>
                  <td>{{$order->created_at->format('d/m/Y H:i:s')}}</td>
               </tr>
               <tr>
                  <th>Ngày đặt hàng</th>
                  <td>{{$order->order_date}}</td>
                  <th>Ngày cập nhật</th>
                  <td>{{$order->updated_at->format('d/m/Y H:i:s')}}</td>
                  <th></th>
                  <td></td>
               </tr>
            </tbody>
         </table>
      </div>


   </div>
</div>

@endsection