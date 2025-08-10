@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Thông báo của bạn</h3>
      </div>

      <!-- Tab Navigation -->
      <div class="wg-box mb-10">
         <div class="notification-tabs">
            <a href="{{ route('admin.notification.user', ['tab' => 'all']) }}"
               class="tab-link {{ $tab === 'all' ? 'active' : '' }}">
               <i class="fas fa-list"></i> Tất cả
            </a>
            <a href="{{ route('admin.notification.user', ['tab' => 'unread']) }}"
               class="tab-link {{ $tab === 'unread' ? 'active' : '' }}">
               <i class="fas fa-envelope"></i> Chưa đọc
            </a>
            <a href="{{ route('admin.notification.user', ['tab' => 'read']) }}"
               class="tab-link {{ $tab === 'read' ? 'active' : '' }}">
               <i class="fas fa-envelope-open"></i> Đã đọc
            </a>
            <a href="{{ route('admin.notification.user', ['tab' => 'archived']) }}"
               class="tab-link {{ $tab === 'archived' ? 'active' : '' }}">
               <i class="fas fa-archive"></i> Đã lưu trữ
            </a>
         </div>
      </div>

      <!-- Notification List -->
      <div class="wg-box">
         <div class="wg-table table-all-user">
            <div class="table-responsive">
               <table class="table table-striped table-bordered">
                  @if($userNotifications->count())
                  <thead>
                     <tr>
                        <th class="text-center" style="width: 50px;">STT</th>
                        <th class="text-center" style="width: 120px;">Tiêu đề</th>
                        <th class="text-center" style="width: 200px;">Nội dung</th>
                        <th class="text-center" style="width: 90px;">Trạng thái</th>
                        <th class="text-center" style="width: 50px;">Hành động</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($userNotifications as $notification)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $notification->notification->name ?? 'Không có tiêu đề' }}
                           <div style="font-size: 12px; color: #888;"> Được tạo
                              {{ $notification->created_at->locale('vi')->diffForHumans(null, true) }} trước
                           </div>
                        </td>
                        <td>{{ $notification->notification->content ?? 'Không có nội dung' }}</td>
                        <td>
                           @if($notification->isRead)
                           <span class="badge bg-success">Đã đọc</span>
                           @else
                           <span class="badge bg-warning">Chưa đọc</span>
                           @endif
                           @if($notification->isArchived)
                           <span class="badge bg-secondary">Đã lưu trữ</span>
                           @endif
                        </td>
                        <td style="text-align: center; padding: 8px;">
                           @if(!$notification->isRead)
                           <form action="{{ route('admin.notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('PATCH')
                              <button type="submit" title="Đánh dấu đã đọc" style="background: none; border: none; padding: 5px; cursor: pointer; color: #28a745; font-size: 16px;">
                                 <i class="bi bi-check-circle-fill"></i>
                              </button>
                           </form>
                           @endif

                           @if(!$notification->isArchived)
                           <form action="{{ route('admin.notifications.archive', $notification->id) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('PATCH')
                              <button type="submit" title="Lưu trữ" style="background: none; border: none; padding: 5px; cursor: pointer; color: #dc3545; font-size: 16px;">
                                 <i class="bi bi-archive"></i>
                              </button>
                           </form>
                           @endif
                        </td>
                     </tr>
                     @empty
                     <tr>
                        <td colspan="6" class="text-center">Không có thông báo nào</td>
                     </tr>

                     @endforelse
                  </tbody>
                  @else
                  <tbody>
                     <tr>
                        <td colspan="5" class="text-center">Bạn không có thông báo lưu trữ</td>
                     </tr>
                  </tbody>
                  @endif
               </table>
            </div>

            <!-- Pagination -->
            @if($userNotifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
               {{ $userNotifications->appends(['tab' => $tab])->links() }}
            </div>
            @endif
         </div>
      </div>
   </div>
</div>

<!-- Custom CSS for Notification Tabs -->
<style>
   .notification-tabs {
      display: flex;
      background: #f8f9fa;
      border-radius: 8px;
      padding: 4px;
      gap: 4px;
   }

   .tab-link {
      flex: 1;
      padding: 12px 16px;
      text-decoration: none;
      color: #6c757d;
      background: transparent;
      border-radius: 6px;
      text-align: center;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
   }

   .tab-link:hover {
      background: #e9ecef;
      color: #495057;
      text-decoration: none;
   }

   .tab-link.active {
      background: #007bff;
      color: white;
      box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
   }

   @media (max-width: 768px) {
      .notification-tabs {
         flex-direction: column;
      }

      .tab-link {
         justify-content: flex-start;
      }
   }
</style>

@endsection