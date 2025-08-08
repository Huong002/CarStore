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
               @if(Session::has('status'))
               <p class="alert alert-success">{{Session::get('status')}}</p>
               @endif
               <table class="table table-striped table-bordered">
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
                     @foreach($userNotifications as $notification)
                     <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$notification->name}}</td>
                        <td>{{$notification->content}}</td>
                        <td><a href="#" target="_blank">
                              {{ $notification->type == 'all' 
                              ? 'Toàn hệ thống' 
                              : ($notification->type == 'admin' 
                                    ? 'Quản trị viên' 
                                    : ($notification->type == 'employee' 
                                       ? 'Nhân viên' 
                                       : 'Khách hàng')) }}
                           </a></td>


                        <td class="text-center align-middle">
                           <div class="list-icon-function d-flex justify-content-center align-items-center gap-4">
                              <!-- <a href="{{ route('admin.notification.edit', ['id' => $notification->id]) }}">
                                 <div class="item edit">
                                    <i class="icon-edit-3"></i>
                                 </div>
                              </a> -->
                              <form action="{{ route('admin.notification.delete', ['id' => $notification->id]) }}" method="POST">
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

               {{$userNotifications->links('pagination::bootstrap-5')}}
            </div>
         </div>
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
            title: 'Bạn có chắn chắn muốn xóa thương hiệu?',
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
   });
</script>
@endpush