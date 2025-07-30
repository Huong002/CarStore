
// Lắng nghe click nút edit trong modal tài khoản
document.addEventListener('click', function (e) {
    const editBtn = e.target.closest('#editButton');
    if (!editBtn) return;

    const modal = editBtn.closest('.modal-content');

    // Hiện input để sửa
    modal.querySelectorAll('.edit-field').forEach(el => el.style.display = 'block');
    // Ẩn text
    modal.querySelectorAll('.info-value').forEach(el => el.style.display = 'none');
    // Hiện nút lưu (footer)
    modal.querySelector('#modalFooter').style.display = 'flex';
    // Ẩn nút edit
    editBtn.style.display = 'none';
});
