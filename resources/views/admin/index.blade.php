@extends('layouts.admin')
@section('content')

<style>
  .badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
  }

  .badge-warning {
    background-color: #ffc107;
    color: #212529;
  }

  .badge-success {
    background-color: #28a745;
    color: #fff;
  }

  .badge-primary {
    background-color: #007bff;
    color: #fff;
  }

  .badge-danger {
    background-color: #dc3545;
    color: #fff;
  }
</style>


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
                  <h4>{{number_format($totalStatis) }}đ</h4>
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
                  <h4>{{number_format($totalStatisPending)}} đ</h4>
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
                  <h4>{{number_format($totalStatis)}} đ</h4>
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
                    Đơn đã duyệt
                  </div>
                  <h4>{{$orderApprored}}</h4>
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
                    Doanh thu đơn đã duyệt
                  </div>
                  <h4>{{number_format($totalStatisApproved)}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="wg-box">
        <div class="flex items-center justify-between">
          <h5>Biểu đồ doanh thu</h5>
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
              <h4>{{number_format($totalStatis, 0, ',', '.')}}</h4>
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
              <h4>{{$orderTotal}}</h4>
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
                  <th style="width: 80px" class="text-center">STT</th>
                  <th class="text-center">Tên</th>
                  <th class="text-center">Sđt</th>
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
                  <td class="text-center">{{ number_format($currentOrder->total - $currentOrder->tax) }} đ</td>
                  <td class="text-center">{{ number_format($currentOrder->tax) }} đ</td>
                  <td class="text-center">{{ number_format($currentOrder->total) }} đ</td>
                  <td class="text-center">
                    <span class="badge 
                      {{ $currentOrder->status == 'pending' ? 'badge-warning' : 
                        ($currentOrder->status == 'approved' ? 'badge-success' : 
                        ($currentOrder->status == 'completed' ? 'badge-primary' : 'badge-danger')) }}">
                      {{ $currentOrder->status == 'pending' ? 'Chờ xử lí' : 
                        ($currentOrder->status == 'approved' ? 'Đã duyệt' : 
                        ($currentOrder->status == 'completed' ? 'Hoàn thành' : 'Đã hủy')) }}
                    </span>
                  </td>
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

@push('scripts')
<script>
  window.chartDataFromServer = <?php echo json_encode($chartData); ?>;

  (function($) {
    var tfLineChart = (function() {
      var chartBar = function() {
        var options = {
          series: [{
              name: "Tổng doanh thu",
              data: window.chartDataFromServer.totalRevenue
            },
            {
              name: "Đang xử lí",
              data: window.chartDataFromServer.pendingRevenue
            },
            {
              name: "Đã duyệt",
              data: window.chartDataFromServer.approvedRevenue
            },
          ],
          chart: {
            type: "bar",
            height: 325,
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "10px",
              endingShape: "rounded",
            },
          },
          dataLabels: {
            enabled: false,
          },
          legend: {
            show: false,
          },
          colors: ["#2377FC", "#FFA500", "#078407", "#FF0000"],
          stroke: {
            show: false,
          },
          xaxis: {
            labels: {
              style: {
                colors: "#212529",
              },
            },
            categories: [
              "Th1",
              "Th2",
              "Th3",
              "Th4",
              "Th5",
              "Th6",
              "Th7",
              "Th8",
              "Th9",
              "Th10",
              "Th11",
              "Th12",
            ],
          },
          yaxis: {
            show: false,
          },
          fill: {
            opacity: 1,
          },
          tooltip: {
            y: {
              formatter: function(val) {
                return new Intl.NumberFormat('vi-VN', {
                  style: 'currency',
                  currency: 'VND'
                }).format(val);
              },
            },
          },
        };

        chart = new ApexCharts(
          document.querySelector("#line-chart-8"),
          options
        );
        if ($("#line-chart-8").length > 0) {
          chart.render();
        }
      };

      /* Function ============ */
      return {
        init: function() {},
        load: function() {
          chartBar();
        },
        resize: function() {},
      };
    })();

    jQuery(document).ready(function() {});

    jQuery(window).on("load", function() {
      tfLineChart.load();
    });

    jQuery(window).on("resize", function() {});
  })(jQuery);
</script>
@endpush