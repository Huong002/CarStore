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
               <form method="GET" action="{{ route('admin.orders') }}" class="form-search" style="display: flex; gap: 15px; align-items: center;">
                  <fieldset class="name">
                     <input type="text" placeholder="Tìm kiếm đơn hàng..." class="" name="name"
                        tabindex="2" value="{{ request('name') }}" aria-required="true">
                     <!-- <div class="button-submit">
                        <button class="" type="submit"><i class="icon-search"></i></button>
                     </div> -->
                  </fieldset>

                  <fieldset class="status" style="min-width: 220px;">
                     <div class="select">
                        <select name="status" onchange="this.form.submit()" style="width: 100%; height: 48px; padding: 0 14px; border: 1px solid #E1E5E9; border-radius: 8px; background: #fff; font-size: 14px; color: #181C32;">
                           <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>
                              Tất cả trạng thái ({{ $statusCounts['all'] ?? 0 }})
                           </option>
                           <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                              Chờ xử lý ({{ $statusCounts['pending'] ?? 0 }})
                           </option>
                           <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                              Đã duyệt ({{ $statusCounts['approved'] ?? 0 }})
                           </option>
                           <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                              Hoàn thành ({{ $statusCounts['completed'] ?? 0 }})
                           </option>
                           <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                              Đã hủy ({{ $statusCounts['cancelled'] ?? 0 }})
                           </option>
                        </select>
                     </div>
                  </fieldset>

               </form>


            </div>


            <div class="wg-table table-all-user">
               <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th class="text-center" style="width:70px">STT</th>
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
                           <!-- <td class="text-center">{{$order->id}}</td> -->
                           <td class="text-center">{{$loop->iteration}}</td>
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
                              @switch($order->status)
                              @case('pending')
                              <span class="badge bg-warning">Chờ xử lý</span>
                              @break
                              @case('approved')
                              <span class="badge bg-info">Đã duyệt</span>
                              @break
                              @case('completed')
                              <span class="badge bg-success">Hoàn thành</span>
                              @break
                              @case('cancelled')
                              <span class="badge bg-danger">Đã hủy</span>
                              @break
                              @default
                              <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                              @endswitch
                           </td>
                           <td class="text-center">{{$order->order_date}}</td>
                           <td class="text-center">{{$order->total_item}}</td>
                           <td>
                              <div class="list-icon-function d-flex justify-content-center align-items-center gap-4 ">
                                 <div style="display: flex; gap: 8px;">
                                    <div class="list-icon-function">
                                       <a href="{{route('admin.order.details', $order->id)}}" target="">
                                          <div class="item eye">
                                             <i class="icon-eye"></i>
                                          </div>
                                       </a>
                                    </div>
                                    @if($order->status != 'pending')
                                    <div class="list-icon-functio">
                                       <a href="{{route('order.invoice.print', $order->id)}}" target="_blank" title="In hóa đơn">
                                          <div class="item print">
                                             <i class="icon-printer"></i>
                                          </div>
                                       </a>
                                    </div>
                                    @endif
                                    @if($order->status == 'pending')
                                    <div class="list-icon-functio">
                                       <form action="{{ route('admin.order.check', $order->id) }}" method="POST" style="display:inline;">
                                          @csrf
                                          <button type="submit" title="Duyệt đơn hàng" style="background: none; border: none; padding: 0;">
                                             <div class="item print">
                                                <i class="bi bi-check-circle-fill"></i>
                                             </div>
                                          </button>
                                       </form>
                                    </div>
                                    @endif
                                 </div>
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
      $(function() {
         $('.delete').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
               form.submit();
            }
         });
      });
   </script>
   @endpush