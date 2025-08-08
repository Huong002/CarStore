<!-- <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: #fff; border-radius: 10px; padding: 20px;">
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
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng">&times;</button>
         </div>
         <div class="modal-body">
            <form action="{{ route('admin.account.update', Auth::user()->id) }}" method="POST" id="editForm">
               @csrf
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
         </div>
         <div class="modal-footer" id="modalFooter" style="display: none;">

            <button type="submit" class="btn-save">Cập nhập</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
         </div>
      </div>
   </div>
</div> -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: #fff; border-radius: 10px; padding: 20px;">
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
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng">&times;</button>
         </div>
         <div class="modal-body">
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <form action="{{ route('admin.account.update', Auth::user()->id) }}" method="POST" id="editForm">
               @csrf
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
         </div>
         <div class="modal-footer" id="modalFooter" style="display: none;">
            <button type="submit" class="btn-save">Cập nhập</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </form>
         </div>
      </div>
   </div>
</div>
<style>
   /* Nền đen trong suốt cho modal */
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

   .avatar {
      border-radius: 50%;
      margin-right: 10px;
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

<!-- <script>
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
</script> -->
<script>
   document.getElementById('editButton').addEventListener('click', function() {
      const editFields = document.querySelectorAll('.edit-field');
      const displayValues = document.querySelectorAll('.info-value');
      const footer = document.getElementById('modalFooter');
      const form = document.getElementById('editForm');

      editFields.forEach(field => field.style.display = 'block');
      displayValues.forEach(value => value.style.display = 'none');
      footer.style.display = 'flex';
      form.style.display = 'block'; // Đảm bảo form hiển thị
      this.style.display = 'none';
   });
</script>