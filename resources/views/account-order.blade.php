@extends('layouts.app')
@section('content')

<main class="pt-90">
   <div class="mb-4 pb-4"></div>
   <section class="my-account container">
      <h2 class="page-title">Lịch sử mua hàng</h2>
      <div class="row">
         <div class="col-lg-3">
            <ul class="account-nav">
               <li><a href="{{route('accountOrder.index')}}" class="menu-link menu-link_us-s">Lịch sử</a></li>
               <li><a href="{{route('accountDetail.index')}}" class="menu-link menu-link_us-s">Tài khoản</a></li>
               <li><a href="{{route('wishlist.index')}}" class="menu-link menu-link_us-s">Yêu thích</a></li>
            </ul>
         </div>

         <div class="col-lg-9">
            <div class="wg-table table-all-user">
               <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th style="width: 80px">STT</th>
                           <th style="white-space:nowrap;" class="text-center">Tên</th>
                           <th class="text-center" style="white-space:nowrap;">Điện thoại</th>
                           <th class="text-center" style="white-space:nowrap;">Giá</th>
                           <th class="text-center" style="white-space:nowrap;">Thuế</th>
                           <th class="text-center" style="white-space:nowrap;">Tổng</th>
                           <th class="text-center" style="white-space:nowrap;">Trạng thái</th>
                           <th class="text-center" style="white-space:nowrap;">Ngày đặt</th>
                           <th class="text-center" style="white-space:nowrap;">Số lượng</th>

                        </tr>
                     </thead>
                     <tbody>
                        @forelse($orders ?? [] as $order)
                        <tr>
                           <td class="text-center">{{ $order->id }}</td>
                           <td class="text-center" style="white-space:nowrap;">{{ $order->customer->customerName ?? 'N/A' }}</td>
                           <td class="text-center" style="white-space:nowrap;">{{ $order->customer->phone ?? 'N/A' }}</td>
                           <td class="text-center" style="white-space:nowrap;">{{ number_format($order->subtotal) }} đ</td>
                           <td class="text-center" style="white-space:nowrap;">{{ number_format($order->calculated_tax) }} đ</td>
                           <td class="text-center" style="white-space:nowrap;">{{ number_format($order->calculated_total ) }} đ</td>

                           <td class="text-center">
                              {!! $order->status_badge !!}
                           </td>
                           <td class="text-center" style="white-space:nowrap;">
                              {{ $order->order_date ? $order->order_date->format('d-m-Y') : 'N/A' }}
                           </td>
                           <td class="text-center">{{ $order->total_item ?? 0 }}</td>

                           <!-- <td class="text-center">
                              <a href="{{ route('order.details', $order->id) }}">
                                 <div class="list-icon-function view-icon">
                                    <div class="item eye">
                                       <i class="fa fa-eye"></i>
                                    </div>
                                 </div>
                              </a>
                           </td> -->
                        </tr>
                        @empty
                        <tr>
                           <td colspan="11" class="text-center py-4">
                              <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                              <a href="{{ route('shop.index') }}" class="btn btn-primary">Mua sắm ngay</a>
                           </td>
                        </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

            </div>
         </div>

      </div>
   </section>
</main>


@endsection