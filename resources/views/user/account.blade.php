<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="user-info">
                    <img src="{{ Auth::user()->image ? asset('images/avatar/' . Auth::user()->image) : asset('images/avatar/user-1.png') }}"
                        alt="Avatar" class="avatar" width="50">
                    <div>
                        <h5 class="modal-title" id="accountModalLabel">{{ Auth::user()->name }}</h5>
                        <span class="email">{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <button type="button" class="btn-edit" id="editButton"><i class="bi bi-pencil"></i></button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body">
                <div class="info-item">
                    <label>Name</label>
                    <span class="info-value">{{ Auth::user()->name }}</span>
                    <input type="text" class="form-control edit-field" name="name" value="{{ Auth::user()->name }}"
                        style="display:none;">
                </div>
                <div class="info-item">
                    <label>Email account</label>
                    <span class="info-value">{{ Auth::user()->email }}</span>
                    <input type="email" class="form-control edit-field" name="email" value="{{ Auth::user()->email }}"
                        style="display:none;">
                </div>
                <div class="info-item">
                    <label>Quyền</label>
                    <span class="info-value">{{ Auth::user()->utype }}</span>
                    <input type="text" class="form-control edit-field" value="{{ Auth::user()->utype }}" disabled
                        style="display:none;">
                </div>
            </div>

            <div class="modal-footer" id="modalFooter" style="display:none;">
                <form action="{{ route('admin.account.update', Auth::user()->id) }}" method="POST" id="editForm">
                    @csrf
                    <button type="submit" class="btn-save">Cập nhật</button>
                </form>
                <button type="button" class="btn btn-secondary btn-sm rounded btn-close-custom" data-bs-dismiss="modal">
                    Đóng
                </button>


            </div>
        </div>
    </div>
</div>
<style>
/* Áp dụng bo góc giống nhau cho cả hai nút */
.btn-save,
.btn-close-custom {
    border-radius: 8px;
    /* bo góc nhẹ */
}

/* Style riêng cho nút Cập nhật */
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
    /* màu đậm hơn khi hover */
}
</style>