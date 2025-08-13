@extends('layouts.admin')
@section('content')


<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Thông báo</h3>
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
               <div class="text-tiny">Thông báo</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <form class="form-search">
                  <fieldset class="name">
                     <input type="text" placeholder="Search here..." class="" name="name"
                        tabindex="2" value="" aria-required="true" required="">
                  </fieldset>
                  <div class="button-submit">
                     <button class="" type="submit"><i class="icon-search"></i></button>
                  </div>
               </form>
            </div>
            <a class="tf-button style-1 w208" href="{{route('admin.notification.add')}}"><i
                  class="icon-plus"></i>Thêm mới</a>
         </div>
         <div class="wg-table table-all-user">
            <div class="table-responsive">

               <table class="table table-striped table-bordered ">
                  <thead>
                     <tr>
                        <th class="text-center" style="width: 50px;">STT</th>
                        <th class="text-center" style="width: 200px;">Tiêu đề</th>
                        <th class="text-center" style="width: 300px;">Nội dung</th>
                        <th class="text-center" style="width: 150px;">Loại thông báo</th>
                        <th style="width: 100px;"></th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($notifications as $noti)
                     <tr>

                        <td class="text-center">{{$loop->iteration}}</td>

                        <td>
                           <a href="javascript:void(0)"
                              class="body-title-2 view-notification"
                              data-bs-toggle="offcanvas"
                              data-bs-target="#notificationContent"
                              data-content="{{ $noti->content }}"
                              data-title="{{ $noti->name }}"
                              data-type="{{ $noti->type == 'all' ? 'Toàn hệ thống' : ($noti->type == 'admin' ? 'Quản trị viên' : ($noti->type == 'employee' ? 'Nhân viên' : 'Khách hàng')) }}"
                              style="cursor: pointer; color: #007bff; text-decoration: none;"
                              title="Click để xem chi tiết">
                              {{ \Illuminate\Support\Str::limit($noti->name, 30) }}
                           </a>
                        </td>
                        <td>
                           {{ \Illuminate\Support\Str::limit(strip_tags($noti->content), 40, '...') }}
                        </td>
                        <td><a href="#" target="_blank">{{$noti->type == 'all' 
                              ? 'Toàn hệ thống' 
                              : ($noti->type == 'admin' 
                                    ? 'Quản trị viên' 
                                    : ($noti->type == 'employee' 
                                       ? 'Nhân viên' 
                                       : 'Khách hàng'))}} </a></td>
                        <td class="text-center align-middle">
                           <div class="list-icon-function d-flex justify-content-center align-items-center gap-4">
                              <a href="{{ route('admin.notification.edit', ['id' => $noti->id]) }}">
                                 <div class="item edit">
                                    <i class="icon-edit-3"></i>
                                 </div>
                              </a>
                              <form action="{{ route('admin.notification.delete', ['id' => $noti->id]) }}" method="POST">
                                 @csrf
                                 @method('DELETE')
                                 <div class="item text-danger delete">
                                    <i class="icon-trash-2"></i>
                                 </div>
                              </form>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            <div class="divider"></div>
            <div class="flex items-centerz justify-between flex-wrap gap10 wgp-pagination">

               {{$notifications->links('pagination::bootstrap-5')}}
            </div>
         </div>
      </div>
   </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="notificationContent" aria-labelledby="notificationContentLabel">
   <div class="offcanvas-header">
      <h5 id="notificationContentLabel">Chi tiết thông báo</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
   </div>
   <div class="offcanvas-body" id="notificationContentBody">
      <div class="mb-3">
         <h6 class="fw-bold">Tiêu đề:</h6>
         <p id="notificationTitle" class="mb-2"></p>
      </div>
      <div class="mb-3">
         <h6 class="fw-bold">Loại thông báo:</h6>
         <span id="notificationType" class="badge bg-primary"></span>
      </div>
      <div class="mb-3">
         <h6 class="fw-bold">Nội dung:</h6>
         <div id="notificationContentText" class="border p-3 rounded" style="min-height: 200px; background-color: #f8f9fa;"></div>
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
         swal({
            title: 'Bạn có chắc chắn muốn xóa thông báo này?',
            icon: "warning",
            buttons: {
               cancel: "Không",
               confirm: {
                  text: "Có",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true
               }
            },
            dangerMode: true,
         }).then(function(result) {
            if (result) form.submit();
         });
      });

      // Handler for notification detail view
      $('.view-notification').on('click', function() {
         const content = $(this).data('content');
         const title = $(this).data('title');
         const type = $(this).data('type');

         $('#notificationContentLabel').text('Chi tiết thông báo');
         $('#notificationTitle').text(title);
         $('#notificationType').text(type);
         $('#notificationContentText').html(content); 
      });
   });
</script>
@endpush