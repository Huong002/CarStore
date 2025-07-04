
@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Đơn hàng</h3>
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
               <div class="text-tiny">Đơn hàng</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <form class="form-search">
                  <fieldset class="name">
                     <input type="text" placeholder="Tìm kiếm đơn hàng..." class="" name="name"
                        tabindex="2" value="" aria-required="true" required="">
                  </fieldset>
                  <div class="button-submit">
                     <button class="" type="submit"><i class="icon-search"></i></button>
                  </div>
               </form>
            </div>
            <a class="tf-button style-1 w208" href="{{route('admin.order.add')}}">
               <i class="icon-plus"></i>Thêm đơn hàng
            </a>
         </div>
         
         <div class="wg-table table-all-user">
            <div class="table-responsive">
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th style="width:70px">ID</th>
                        <th class="text-center">Khách hàng</th>
                        <th class="text-center">Nhân viên</th>
                        <th class="text-center">Thuế</th>
                        <th class="text-center">Tổng tiền</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ngày đặt</th>
                        <th class="text-center">Số sản phẩm</th>
                        <th class="text-center">Hành động</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($orders as $order)
                     <tr>
                        <td class="text-center">{{$order->id}}</td>
                        <td class="text-center">
                           @if($order->customer)
                              {{$order->customer->customerName}}
                           @else
                              <span class="text-muted">Không có</span>
                           @endif
                        </td>
                        <td class="text-center">
                           @if($order->employee)
                              {{$order->employee->name}}
                           @else
                              <span class="text-muted">Không có</span>
                           @endif
                        </td>
                        <td class="text-center">{{number_format($order->tax, 0, ',', '.')}} VNĐ</td>
                        <td class="text-center">{{number_format($order->total, 0, ',', '.')}} VNĐ</td>
                        <td class="text-center">
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
                        <td class="text-center">{{$order->order_date}}</td>
                        <td class="text-center">{{$order->total_item}}</td>
                        <td>
                           <div class="list-icon-function">
                              <a href="{{route('admin.order.details', $order->id)}}" target="_blank">
                                 <div class="item eye">
                                    <i class="icon-eye"></i>
                                 </div>
                              </a>
                              
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>

         <div class="divider"></div>
         <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{$orders->links()}}
         </div>
      </div>
   </div>
</div>

@endsection

@push('scripts')
<script>
$(function(){
    $('.delete').on('click', function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        if(confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')){
            form.submit();
        }
    });
});
</script>
@endpush