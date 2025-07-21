@extends('layouts.admin')

@section('content')
<style>
   .nav-link.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background-color: #0d6efd;
   }

   .message-item:hover {
      background-color: #f8f9fa;
      cursor: pointer;
   }

   .message-item.active {
      border-left: 2px solid #0d6efd;
      background-color: #e9ecef;
   }

   .card {
      border-radius: 14px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
   }

   .card-header {
      background: #f7f9fb;
      border-radius: 14px 14px 0 0;
      padding: 18px 24px;
   }

   .card-body {
      padding: 18px 24px;
   }

   .message-item {
      border-bottom: 1px solid #f0f0f0;
      min-height: 72px;
      padding: 16px 20px;
      font-size: 16px;
   }

   .message-item:last-child {
      border-bottom: none;
   }

   .message-list-scroll {
      max-height: 420px;
      overflow-y: auto;
   }

   .container-noti {
      max-width: 1200px;
      margin: 0 auto;
   }

   @media (max-width: 991px) {
      .container-noti {
         max-width: 100%;
         padding: 0 8px;
      }

      .card-header,
      .card-body {
         padding: 12px 8px;
      }

      .message-item {
         font-size: 15px;
         padding: 12px 8px;
      }
   }
</style>

<div class="container-noti py-4">
   <!-- Tab Navigation -->
   <nav>
      <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
         @php
         $tabs = [
         ['value' => 'unassigned', 'label' => 'Unassigned', 'count' => 88],
         ['value' => 'assigned-to-me', 'label' => 'Assigned to me', 'count' => 1515],
         ['value' => 'all-open', 'label' => 'All open', 'count' => 1603],
         ['value' => 'chat', 'label' => 'Chat', 'count' => 991],
         ];
         @endphp
         @foreach ($tabs as $tab)
         <button class="nav-link position-relative {{ request()->query('tab') == $tab['value'] ? 'active' : '' }}"
            id="nav-{{ $tab['value'] }}-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-{{ $tab['value'] }}"
            type="button"
            role="tab"
            aria-controls="nav-{{ $tab['value'] }}"
            aria-selected="{{ request()->query('tab') == $tab['value'] ? 'true' : 'false' }}">
            {{ $tab['label'] }} <span class="badge bg-secondary">{{ $tab['count'] }}</span>
         </button>
         @endforeach
      </div>
   </nav>

   <!-- Main Content Grid -->
   <div class="row g-4">
      <!-- Message List -->
      <div class="col-12 col-lg-4">
         <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
               <div class="d-flex align-items-center gap-2">
                  <input type="checkbox" class="form-check-input me-2">
                  <div class="btn-group" role="group">
                     <button type="button" class="btn btn-outline-secondary btn-sm">Open</button>
                     <button type="button" class="btn btn-outline-secondary btn-sm">Closed</button>
                  </div>
               </div>
               <select class="form-select form-select-sm w-auto">
                  <option>Newest</option>
                  <option>Oldest</option>
               </select>
            </div>
            <div class="card-body p-0 message-list-scroll">
               @foreach (range(1, 5) as $index)
               <div class="message-item {{ $index == 1 ? 'active' : '' }} d-flex align-items-start">
                  <input type="checkbox" class="form-check-input me-2 mt-1">
                  <div class="flex-grow-1">
                     <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Luxurious Rubber Table</h6>
                        <small class="text-muted">23 Dec 2021</small>
                     </div>
                     <p class="text-muted mb-0 mt-1">Soluta atque omnis ea aliquid. Dolorum quis perferendis...</p>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>

      <!-- Message Details -->
      <div class="col-12 col-lg-8">
         <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
               <div class="d-flex align-items-center gap-2">
                  <h5 class="mb-0 fw-semibold">Luxurious Rubber Table</h5>
                  <span class="badge bg-danger ms-2">Product Issue</span>
               </div>
               <select class="form-select form-select-sm w-auto">
                  <option>Select Agent</option>
                  <option>Agent 1</option>
               </select>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-start mb-3">
                  <div class="me-3">
                     <span class="d-inline-block bg-primary text-white rounded-circle" style="width: 40px; height: 40px; line-height: 40px; text-align: center;">JD</span>
                  </div>
                  <div>
                     <h6 class="mb-0 fw-semibold">John Doe</h6>
                     <p class="text-muted mb-1">john.doe@example.com <a href="#" class="ms-1"><svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M19 19H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
                           </svg></a></p>
                     <p class="text-muted mb-0">#123 <span class="ms-1">Open 23 Dec 2021</span></p>
                  </div>
               </div>
               <p class="text-secondary">Soluta atque omnis ea aliquid. Dolorum quis perferendis...</p>
               <p class="text-secondary">Maxime suscipit fuga ducimus perspiciatis nemo porro nihil eaque a ab molestias praesentium voluptatum...</p>
               <p class="text-secondary">Regards,<br>John Doe,<br>Company Name</p>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection