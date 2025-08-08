<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: #fff; border-radius: 10px; padding: 20px;">
         <div class="modal-header">
            <div class="user-info">
               <div class="avatar-container">
                  <img src="{{ Auth::user()->image ? asset('images/avatar/' . Auth::user()->image) : asset('images/avatar/user-1.png') }}"
                     alt="Avatar" class="avatar" width="50" id="avatarImage">
                  <div class="avatar-overlay" id="avatarOverlay">Click để đổi ảnh</div>
               </div>
               <div>
                  <h5 class="modal-title" id="accountModalLabel">{{ Auth::user()->name }}</h5>
                  <span class="email">{{ Auth::user()->email }}</span>
               </div>
            </div>
            <button type="button" class="btn-edit" id="editButton"><i class="bi bi-pencil"></i></button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng">&times;</button>
         </div>
         <div class="modal-body">
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <form action="{{ route('admin.account.update', Auth::user()->id) }}" method="POST" id="editForm" enctype="multipart/form-data">
               @csrf
               <input type="file" id="avatarInput" name="image" accept="image/*" style="display: none;">
               <div class="info-item">
                  <label>Name</label>
                  <span class="info-value" id="displayName">{{ Auth::user()->name }}</span>
                  <input type="text" class="form-control edit-field" id="name" name="name" value="{{ Auth::user()->name }}" style="display: none;">
               </div>
               <div class="info-item">
                  <label>Email account</label>
                  <span class="info-value" id="displayEmail">{{ Auth::user()->email }}</span>
                  <input type="email" class="form-control edit-field" id="email" name="email" value="{{ Auth::user()->email }}" style="display: none;">
               </div>
               <div class="info-item">
                  <label>Quyền</label>
                  <span class="info-value" id="displayRole">{{ Auth::user()->utype }}</span>
                  <input type="text" class="form-control edit-field" value="{{ Auth::user()->utype }}" disabled style="display: none;">
               </div>
            </form>
         </div>
         <div class="modal-footer" id="modalFooter" style="display: none;">
            <button type="submit" class="btn-save" form="editForm" onclick="console.log('Submit button clicked'); console.log('Form data:', new FormData(document.getElementById('editForm'))); console.log('Avatar file:', document.getElementById('avatarInput').files);">Cập nhật</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
         </div>
      </div>
   </div>
</div>

<style>
   .modal-backdrop.show {
      background-color: rgba(0, 0, 0, 0.7) !important;
   }

   .modal-content {
      border: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      padding: 20px;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
   }

   .modal-header {
      border-bottom: 1px solid #eee;
      padding-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: space-between;
   }

   .user-info {
      display: flex;
      align-items: center;
   }

   .avatar-container {
      position: relative;
      margin-right: 10px;
   }

   .avatar {
      border-radius: 50%;
      cursor: pointer;
      transition: opacity 0.3s;
   }

   .avatar:hover {
      opacity: 0.7;
   }

   .avatar-overlay {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 50px;
      height: 50px;
      background: rgba(0, 0, 0, 0.5);
      color: #fff;
      font-size: 12px;
      text-align: center;
      line-height: 50px;
      border-radius: 50%;
      pointer-events: none;
   }

   .avatar-container:hover .avatar-overlay {
      display: block;
   }

   .modal-title {
      margin: 0;
      font-size: 16px;
      font-weight: 500;
      color: #333;
   }

   .email {
      font-size: 12px;
      color: #666;
   }

   .btn-edit {
      background: none;
      border: none;
      font-size: 16px;
      color: #007bff;
      cursor: pointer;
   }

   .btn-edit:hover {
      color: #0056b3;
   }

   .btn-close {
      background: none;
      border: none;
      font-size: 20px;
      color: #666;
      cursor: pointer;
   }

   .modal-body {
      padding: 15px 0;
   }

   .info-item {
      display: flex;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid #eee;
   }

   .info-item label {
      font-weight: 500;
      color: #666;
      width: 120px;
      margin-right: 10px;
   }

   .info-value {
      font-size: 14px;
      color: #333;
      flex-grow: 1;
   }

   .edit-field {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 5px;
      font-size: 14px;
      color: #333;
      background-color: #fff;
      width: 100%;
   }

   .edit-field:focus {
      border-color: #007bff;
      outline: none;
   }

   .modal-footer {
      border-top: 1px solid #eee;
      padding-top: 15px;
      justify-content: flex-end;
   }

   .btn-save {
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 8px 16px;
      font-size: 14px;
      cursor: pointer;
   }

   .btn-save:hover {
      background-color: #0056b3;
   }

   .btn-close {
      margin-left: 10px;
      background: none;
      border: none;
      color: #666;
      font-size: 14px;
      cursor: pointer;
   }

   .btn-close:hover {
      color: #333;
   }
</style>

<script>
   document.getElementById('editButton').addEventListener('click', function() {
      const editFields = document.querySelectorAll('.edit-field');
      const displayValues = document.querySelectorAll('.info-value');
      const footer = document.getElementById('modalFooter');
      const form = document.getElementById('editForm');

      editFields.forEach(field => field.style.display = 'block');
      displayValues.forEach(value => value.style.display = 'none');
      footer.style.display = 'flex';
      form.style.display = 'block';
      this.style.display = 'none';
   });

   // Xử lý click vào ảnh để chọn file mới
   document.getElementById('avatarImage').addEventListener('click', function() {
      document.getElementById('avatarInput').click();
   });

   // Xử lý preview ảnh khi chọn file
   document.getElementById('avatarInput').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
         const reader = new FileReader();
         reader.onload = function(e) {
            document.getElementById('avatarImage').src = e.target.result;
         };
         reader.readAsDataURL(file);

         // Hiển thị footer và form để cho phép lưu ảnh
         const editFields = document.querySelectorAll('.edit-field');
         const displayValues = document.querySelectorAll('.info-value');

         editFields.forEach(field => field.style.display = 'block');
         displayValues.forEach(value => value.style.display = 'none');

         document.getElementById('modalFooter').style.display = 'flex';
         document.getElementById('editForm').style.display = 'block';
         document.getElementById('editButton').style.display = 'none';
      }
   });

   // Cập nhật avatar trong header sau khi form submit thành công
   document.getElementById('editForm').addEventListener('submit', function(e) {
      // Kiểm tra nếu có file avatar được chọn
      const avatarInput = document.getElementById('avatarInput');
      if (avatarInput.files.length > 0) {
         // Sau khi form submit thành công, cập nhật avatar trong header
         setTimeout(function() {
            const newAvatarSrc = document.getElementById('avatarImage').src;
            const headerAvatar = document.querySelector('.user-avatar');
            if (headerAvatar) {
               headerAvatar.src = newAvatarSrc;
            }
         }, 1000);
      }
   });

   // Nếu có thông báo thành công, tự động cập nhật avatar trong header
   @if(session('message'))
   document.addEventListener('DOMContentLoaded', function() {
      // Force reload avatar với timestamp để tránh cache
      const timestamp = new Date().getTime();
      const headerAvatar = document.querySelector('.user-avatar');
      const modalAvatar = document.getElementById('avatarImage');

      if (headerAvatar && modalAvatar) {
         const currentSrc = modalAvatar.src;
         // Nếu src chứa timestamp thì loại bỏ để tránh duplicate
         const cleanSrc = currentSrc.split('?')[0];
         const newSrc = cleanSrc + '?v=' + timestamp;

         headerAvatar.src = newSrc;
         modalAvatar.src = newSrc;
      }
   });
   @endif
</script>