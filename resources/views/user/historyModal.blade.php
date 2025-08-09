<!-- Modal Lịch sử mua hàng -->

<style>
/* Ghi đè nền của thead nếu muốn giữ hoặc chỉnh */
.table-light {
    background-color: transparent !important;
    /* hoặc remove class này nếu không cần */
}

/* Style các ô tiêu đề trong thead */
.table thead th {
    background-color: #fff !important;
    /* nền trắng cho th */
    font-weight: 700;
    /* đậm hơn */
    text-align: left;
    padding: 12px 15px;
    white-space: nowrap;
    color: #000 !important;
    /* màu đen tuyệt đối */
}

/* Đường kẻ ngang phân cách giữa thead và tbody */
.table thead tr {
    border-bottom: 2px solid #999;
    /* đường kẻ xám */
}

/* Style cho các ô dữ liệu trong tbody */
.table tbody td {
    padding: 10px 15px;
    color: #343a40;
    /* màu chữ tối hơn một chút */
    vertical-align: middle;
    /* canh giữa theo chiều dọc */
    border-top: 1px solid #dee2e6;
    /* đường kẻ ngang nhẹ giữa các dòng */
}
</style>


<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <!-- modal-xl để rộng hơn -->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="historyModalLabel">
                    <i class="fas fa-history me-2"></i> Lịch sử mua hàng
                </h3>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Ngày đặt</th>
                            <th>Khách hàng</th>
                            <th>Nhân viên xử lý</th>
                            <th>Tổng số mặt hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Số tiền đặt cọc</th>
                            <th>Ngày đặt cọc</th>
                            <th>Sản phẩm đặt cọc</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <tr>
                            <td colspan="11" class="text-center">Đang tải dữ liệu...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết đơn hàng -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="bi bi-check-circle-fill" style="color:#198754; margin-right:8px; font-size:1.3rem;"></i>

                    Chi tiết đơn hàng #<span id="detailOrderId"></span>
                </h4>


                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailBody">
                        <tr>
                            <td colspan="4" class="text-center">Chưa có dữ liệu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
// Load lịch sử đơn hàng khi mở modal historyModal
var historyModal = document.getElementById('historyModal');
historyModal.addEventListener('show.bs.modal', function(event) {
    var tbody = document.getElementById('ordersTableBody');
    tbody.innerHTML = '<tr><td colspan="11" class="text-center">Đang tải dữ liệu...</td></tr>';

    fetch("{{ route('orders.history') }}")
        .then(response => response.json())
        .then(data => {
            if (!data.orders || data.orders.length === 0) {
                tbody.innerHTML =
                    '<tr><td colspan="11" class="text-center">Không có đơn hàng nào.</td></tr>';
                return;
            }
            var rows = '';
            data.orders.forEach(order => {
                rows += `<tr>
                    <td>${order.id}</td>
                    <td>${new Date(order.order_date).toLocaleDateString('vi-VN')}</td>
                    <td>${order.customer_name ?? ''}</td>
                    <td>${order.employee_name ?? ''}</td>
                    <td>${order.total_item}</td>
                    <td>${parseFloat(order.total).toLocaleString('vi-VN', {style: 'currency', currency: 'VND'})}</td>
                    <td>${order.status}</td>
                    <td>${order.deposit_amount !== null ? parseFloat(order.deposit_amount).toLocaleString('vi-VN', {style: 'currency', currency: 'VND'}) : '-'}</td>
                    <td>${order.deposit_date ? new Date(order.deposit_date).toLocaleDateString('vi-VN') : '-'}</td>
                    <td>${order.product_name ?? '-'}</td>
                    <td>
                        <button
                            class="btn btn-primary btn-sm btn-view-detail"
                            data-order-id="${order.id}">
                            Xem
                        </button>
                    </td>
                </tr>`;
            });
            tbody.innerHTML = rows;
        })
        .catch(err => {
            tbody.innerHTML =
                '<tr><td colspan="11" class="text-center text-danger">Lỗi tải dữ liệu.</td></tr>';
            console.error(err);
        });
});

// Bắt sự kiện click nút "Xem" trong bảng lịch sử để mở modal chi tiết đơn hàng
document.getElementById('ordersTableBody').addEventListener('click', function(event) {
    const target = event.target;
    if (target.classList.contains('btn-view-detail')) {
        const orderId = target.getAttribute('data-order-id');
        var orderDetailModal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
        orderDetailModal.show();
        loadOrderDetail(orderId);
    }
});

// Hàm lấy chi tiết đơn hàng và hiển thị trong modal chi tiết
function loadOrderDetail(orderId) {
    document.getElementById('detailOrderId').textContent = orderId;
    var tbody = document.getElementById('orderDetailBody');
    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Đang tải dữ liệu...</td></tr>';

    fetch(`/orders/${orderId}/detail`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">${data.error}</td></tr>`;
                return;
            }
            if (!data.details || data.details.length === 0) {
                tbody.innerHTML =
                    '<tr><td colspan="4" class="text-center">Không có sản phẩm nào trong đơn.</td></tr>';
                return;
            }
            var rows = '';
            data.details.forEach(item => {
                rows += `<tr>
                    <td>${item.product_name ?? 'Sản phẩm'}</td>
                    <td>${item.quantity}</td>
                    <td>${parseFloat(item.price).toLocaleString('vi-VN', {style: 'currency', currency: 'VND'})}</td>
                    <td>${(item.quantity * item.price).toLocaleString('vi-VN', {style: 'currency', currency: 'VND'})}</td>
                </tr>`;
            });
            tbody.innerHTML = rows;
        })
        .catch(err => {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Lỗi tải dữ liệu.</td></tr>';
            console.error(err);
        });
}
</script>