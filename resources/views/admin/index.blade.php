@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
  <div class="main-content-wrap">
    <div class="tf-section-2 mb-30">
      <div class="flex gap20 flex-wrap-mobile">
        <div class="w-half">
          <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-shopping-bag"></i>
                </div>
                <div>
                  <div class="body-text mb-2">Tổng hóa đơn</div>
                  <h4>{{ $orderTotal }}</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-dollar-sign"></i>
                </div>
                <div>
                  <div class="body-text mb-2">Tổng doanh thu</div>
                  <h4>{{number_format($totalStatis) }}VNĐ</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-shopping-bag"></i>
                </div>
                <div>
                  <div class="body-text mb-2">Đơn hàng chờ xử lí</div>
                  <h4>{{$orderPending}}</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="wg-chart-default">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-dollar-sign"></i>
                </div>
                <div>
                  <div class="body-text mb-2">
                    Doanh thu đơn chờ duyệt
                  </div>
                  <h4>{{number_format($totalStatisPending)}} VNĐ</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="w-half">
          <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-shopping-bag"></i>
                </div>
                <div>
                  <div class="body-text mb-2">
                    Đơn hàng đã giao
                  </div>
                  <h4>{{$orderComplated}}</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-dollar-sign"></i>
                </div>
                <div>
                  <div class="body-text mb-2">
                    Doanh thu đơn đã giao
                  </div>
                  <h4>{{number_format($totalStatis)}} VNĐ</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-shopping-bag"></i>
                </div>
                <div>
                  <div class="body-text mb-2">
                    Đơn đã hủy
                  </div>
                  <h4>{{$orderCancelled}}</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="wg-chart-default">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap14">
                <div class="image ic-bg">
                  <i class="icon-dollar-sign"></i>
                </div>
                <div>
                  <div class="body-text mb-2">
                    Doanh thu đơn đã hủy
                  </div>
                  <h4>{{number_format($totalStatisCancelled)}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="wg-box">
        <div class="flex items-center justify-between">
          <h5>Earnings revenue</h5>
          <div class="dropdown default">
            <button
              class="btn btn-secondary dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              <span class="icon-more"><i class="icon-more-horizontal"></i></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a href="javascript:void(0);">Theo tháng</a>
              </li>
              <li>
                <a href="javascript:void(0);">Theo năm</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="flex flex-wrap gap40">
          <div>
            <div class="mb-2">
              <div class="block-legend">
                <div class="dot t1"></div>
                <div class="text-tiny">Doanh thu</div>
              </div>
            </div>
            <div class="flex items-center gap10">
              <h4>$37,802</h4>
              <div class="box-icon-trending up">
                <i class="icon-trending-up"></i>
                <div class="body-title number">0.56%</div>
              </div>
            </div>
          </div>
          <div>
            <div class="mb-2">
              <div class="block-legend">
                <div class="dot t2"></div>
                <div class="text-tiny">Hóa đơn</div>
              </div>
            </div>
            <div class="flex items-center gap10">
              <h4>$28,305</h4>
              <div class="box-icon-trending up">
                <i class="icon-trending-up"></i>
                <div class="body-title number">0.56%</div>
              </div>
            </div>
          </div>
        </div>
        <div id="line-chart-8"></div>
      </div>
    </div>
    <div class="tf-section mb-30">
      <div class="wg-box">
        <div class="flex items-center justify-between">
          <h5>Đơn gần đây</h5>
          <div class="dropdown default">
            <a class="btn btn-secondary dropdown-toggle" href="{{route('admin.orders')}}">
              <span class="view-all">Xem toàn bộ</span>
            </a>
          </div>
        </div>
        <div class="wg-table table-all-user">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="width: 80px">STT</th>
                  <th>Tên</th>
                  <th class="text-center">Phone</th>
                  <th class="text-center">Tạm tính</th>
                  <th class="text-center">Tax</th>
                  <th class="text-center">Tổng</th>

                  <th class="text-center">Trạng thái</th>
                  <th class="text-center">Ngày giao</th>
                  <th class="text-center">Sổ lượng</th>
                  <!-- <th class="text-center">Delivered On</th> -->
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($currentOrders as $currentOrder)
                <tr>
                  <td class="text-center">{{$loop->iteration}}</td>
                  <td class="text-center">{{ $currentOrder->customer->customerName ?? 'N/A' }}</td>
                  <td class="text-center">{{ $currentOrder->customer->phone ?? 'N/A' }}</td>
                  <td class="text-center">{{ number_format($currentOrder->total - $currentOrder->tax) }} VNĐ</td>
                  <td class="text-center">{{ number_format($currentOrder->tax) }} VNĐ</td>
                  <td class="text-center">{{ number_format($currentOrder->total) }} VNĐ</td>
                  <td class="text-center">{{ $currentOrder->status }}</td>
                  <td class="text-center">{{ $currentOrder->order_date }}</td>
                  <td class="text-center">{{ $currentOrder->total_item }}</td>
                  <!-- <td class="text-center">{{ $currentOrder->delivered_on ?? '' }}</td> -->
                  <td class="text-center">
                    <a href="{{ route('admin.order.details', $currentOrder->id) }}">
                      <div class="list-icon-function view-icon">
                        <div class="item eye">
                          <i class="icon-eye"></i>
                        </div>
                      </div>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection