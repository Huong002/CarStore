<!-- account.blade.php -->

<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('admin.account.update', Auth::user()->id) }}" method="POST"
                enctype="multipart/form-data" id="editForm">


                @csrf

                <div class="modal-header">
                    <div class="user-info position-relative">
                        <img src="{{ Auth::user()->image ? asset('images/avatar/' . Auth::user()->image) : asset('images/avatar/user-1.png') }}"
                            alt="Avatar" class="avatar" width="60" height="60"
                            style="border-radius: 50%; object-fit: cover;">

                        <!-- Icon thay đổi ảnh -->
                        <label for="imageInput" class="position-absolute image-edit-icon"
                            style="bottom: 0; right: 0; cursor: pointer; display: none;">
                            <i class="bi bi-camera-fill fs-5 text-primary bg-white p-1 rounded-circle"></i>
                        </label>
                        <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                    </div>
                    <div>
                        <h5 class="modal-title ms-2" id="accountModalLabel">{{ Auth::user()->name }}</h5>
                        <span class="email ms-2">{{ Auth::user()->email }}</span>
                    </div>
                    <button type="button" class="btn-edit" id="editButton"><i class="bi bi-pencil"></i></button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <div class="info-item mb-3">
                        <label class="form-label">Tên</label>
                        <span class="info-value">{{ Auth::user()->name }}</span>
                        <input type="text" class="form-control edit-field" name="name" value="{{ Auth::user()->name }}"
                            style="display:none;">
                    </div>
                    <div class="info-item mb-3">
                        <label class="form-label">Email</label>
                        <span class="info-value">{{ Auth::user()->email }}</span>
                        <input type="email" class="form-control edit-field" name="email"
                            value="{{ Auth::user()->email }}" style="display:none;">
                    </div>
                    <div class="info-item mb-3">
                        <label class="form-label">Quyền</label>
                        <span class="info-value">{{ Auth::user()->utype }}</span>
                        <input type="text" class="form-control edit-field" value="{{ Auth::user()->utype }}" disabled
                            style="display:none;">
                    </div>
                </div>

                <div class="modal-footer" id="modalFooter" style="display:none;">
                    <button type="submit" class="btn-save">Cập nhật</button>
                    <button type="button" class="btn btn-secondary btn-sm rounded btn-close-custom"
                        data-bs-dismiss="modal">Đóng</button>
                </div>
            </form>

        </div>
    </div>
</div>


@if(session('account_updated'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div class="toast align-items-center text-white border-0 show shadow" role="alert" aria-live="assertive"
        aria-atomic="true" id="successToast" style="background-color: #5e83ae;">
        <div class="d-flex align-items-center">
            <!-- Icon check thành công -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                class="bi bi-check-circle-fill me-3 ms-2" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08-.02l3.992-4.99a.75.75 0 0 0-1.142-.976L7.525 9.57 5.383 7.383a.75.75 0 1 0-1.06 1.06l2.646 2.646z" />
            </svg>

            <div class="toast-body fs-6 fw-semibold">
                {{ session('account_updated') }}
            </div>
        </div>
    </div>
</div>
@endif





<!-- Styles -->
<style>
.btn-save,
.btn-close-custom {
    border-radius: 8px;
}

.btn-save {
    background-color: #5E83AE;
    border: none;
    color: #fff;
    padding: 6px 14px;
    font-size: 14px;
    cursor: pointer;
}

.btn-save:hover {
    background-color: #4d6d94;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-item label {
    font-weight: bold;
}
</style>

<script>
document.getElementById('editButton').addEventListener('click', function() {
    const inputs = document.querySelectorAll('.edit-field');
    const values = document.querySelectorAll('.info-value');
    const footer = document.getElementById('modalFooter');
    const imageEditIcon = document.querySelector('.image-edit-icon');

    values.forEach(v => v.style.display = 'none');
    inputs.forEach(i => i.style.display = 'block');
    footer.style.display = 'flex';

    //  Hiển thị icon chỉnh sửa ảnh
    if (imageEditIcon) {
        imageEditIcon.style.display = 'block';
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Nếu có toast (Blade đã render #successToast khi có session('account_updated')), mở modal và ẩn toast sau 3s
    const toast = document.getElementById('successToast');
    const accountModalEl = document.getElementById('accountModal');

    if (toast && accountModalEl) {
        // mở modal để người dùng xem thông tin mới
        const accountModal = new bootstrap.Modal(accountModalEl);
        accountModal.show();

        // Khi modal đã show, đảm bảo nó ở chế độ "view", không phải chế độ edit
        accountModalEl.addEventListener('shown.bs.modal', function handler() {
            const inputs = document.querySelectorAll('.edit-field');
            const values = document.querySelectorAll('.info-value');
            const footer = document.getElementById('modalFooter');
            const imageEditIcon = document.querySelector('.image-edit-icon');

            values.forEach(v => v.style.display = 'block');
            inputs.forEach(i => i.style.display = 'none');
            if (footer) footer.style.display = 'none';
            if (imageEditIcon) imageEditIcon.style.display = 'none';

            // chỉ chạy 1 lần
            accountModalEl.removeEventListener('shown.bs.modal', handler);
        });

        // Ẩn toast sau 3s
        setTimeout(() => {
            const t = document.getElementById('successToast');
            if (t) t.remove();
        }, 3000);

        return; // đã xử lý trường hợp có session
    }

    // Nếu không có toast (người mở modal bằng tay), vẫn giữ xử lý reset khi modal show
    if (accountModalEl) {
        accountModalEl.addEventListener('show.bs.modal', function() {
            const inputs = document.querySelectorAll('.edit-field');
            const values = document.querySelectorAll('.info-value');
            const footer = document.getElementById('modalFooter');
            const imageEditIcon = document.querySelector('.image-edit-icon');

            values.forEach(v => v.style.display = 'block');
            inputs.forEach(i => i.style.display = 'none');
            if (footer) footer.style.display = 'none';
            if (imageEditIcon) imageEditIcon.style.display = 'none';
        });
    }
});
</script>