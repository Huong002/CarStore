@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Thông báo</h3>
      </div>

      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a class="nav-link {{ $tab === 'all' ? 'active' : '' }}" href="{{ route('admin.notifications', ['tab' => 'all']) }}">Tất cả</a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ $tab === 'unread' ? 'active' : '' }}" href="{{ route('admin.notifications', ['tab' => 'unread']) }}">Chưa đọc</a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ $tab === 'read' ? 'active' : '' }}" href="{{ route('admin.notifications', ['tab' => 'read']) }}">Đã đọc</a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ $tab === 'archived' ? 'active' : '' }}" href="{{ route('admin.notifications', ['tab' => 'archived']) }}">Đã lưu trữ</a>
         </li>
      </ul>

      <div class="wg-box">
         <div class="table-responsive">
            <table class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>STT</th>
                     <th>Tiêu đề</th>
                     <th>Nội dung</th>
                     <th>Trạng thái</th>
                     <th>Hành động</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($userNotifications as $notification)
                  <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $notification->notification->name ?? 'Không có tiêu đề' }}</td>
                     <td>{{ $notification->notification->content ?? 'Không có nội dung' }}</td>
                     <td>
                        @if($notification->isRead)
                        <span class="badge badge-success">Đã đọc</span>
                        @else
                        <span class="badge badge-warning">Chưa đọc</span>
                        @endif

                        @if($notification->isArchived)
                        <span class="badge badge-secondary">Đã lưu trữ</span>
                        @endif
                     </td>
                     <td>
                        <form action="" method="POST">
                           @csrf
                           @method('PATCH')
                           <button class="btn btn-sm btn-primary">Đánh dấu đã đọc</button>
                           <button class="btn btn-sm btn-secondary">Lưu trữ</button>
                        </form>
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="5" class="text-center">Không có thông báo nào</td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>

         <div class="d-flex justify-content-center">
            {{ $userNotifications->links() }}
         </div>
      </div>
   </div>
</div>

@endsection