@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row g-4">
        <!-- Cột trái: Thông tin -->
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body p-4">
                    <!-- Tên cửa hàng nổi bật -->
                    <h2 class="store-title mb-4">
                        HT Auto Store
                    </h2>

                    <p class="fs-5 text-muted mb-4">
                        Cửa hàng kinh doanh ô tô <strong>HT Auto Store</strong><br>
                        Địa chỉ: <span class="fw-bold text-dark">Cao Lãnh, Đồng Tháp</span>
                    </p>

                    <h5 class="fw-bold mb-3 text-dark">Liên hệ với chúng tôi</h5>
                    <ul class="list-unstyled fs-6">
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                            <strong>Điện thoại:</strong> 0909 123 456
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            <strong>Email:</strong> htauto.store@gmail.com
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-globe text-primary me-2"></i>
                            <strong>Website:</strong>
                            <a href="https://htauto.vn" class="text-decoration-none" target="_blank">htauto.vn</a>
                        </li>
                    </ul>

                    <div class="d-flex gap-3 mb-4">
                        <a href="#" target="_blank" style="color:#1877f2; font-size:1.5rem;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" target="_blank" style="color:#d00000; font-size:1.5rem;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" target="_blank" style="color:#1da1f2; font-size:1.5rem;">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>

                    <a href="https://www.google.com/maps/search/?api=1&query=10.4553,105.6326" target="_blank"
                        class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-geo-alt-fill me-2"></i> Xem chỉ đường
                    </a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Bản đồ -->
        <div class="col-lg-7">
            <div id="map" class="rounded shadow-lg" style="height: 500px;"></div>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
/* Làm nổi bật tên cửa hàng */
.store-title {
    font-weight: 900;
    font-size: 2.3rem;
    color: #b30000;
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
    display: inline-block;
}

.store-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 100%;
    height: 4px;
    border-radius: 2px;
    background: #b30000;
}

/* Bản đồ */
.leaflet-container {
    border: 3px solid #3498db;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.2);
}

/* Popup */
.leaflet-popup-content-wrapper {
    background: #3498db;
    color: white;
    border-radius: 12px;
    font-weight: bold;
}

.leaflet-popup-tip {
    background: #3498db;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var lat = 10.4553;
    var lng = 105.6326;

    // Khởi tạo map
    var map = L.map('map').setView([lat, lng], 17);

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Marker chính
    var redIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    var marker = L.marker([lat, lng], {
        icon: redIcon
    }).addTo(map);
    marker.bindPopup("<b>HT Auto Store</b><br>Kinh doanh ô tô chất lượng.").openPopup();

    // Đã loại bỏ chấm pulse đỏ
});
</script>
@endsection