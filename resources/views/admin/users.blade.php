@extends('layouts.admin')
@section('content')


<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Người dùng</h3>
         <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
               <a href="index.html">
                  <div class="text-tiny">Dashboard</div>
               </a>
            </li>
            <li>
               <i class="icon-chevron-right"></i>
            </li>
            <li>
               <div class="text-tiny">Danh sách</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <form class="form-search">
                  <fieldset class="name">
                     <input type="text" placeholder="oSearch here..." class="" name="name"
                        tabindex="2" value="{{request('name')}}" aria-required="true" required="">
                  </fieldset>
                  <div class="button-submit">
                     <button class="" type="submit"><i class="icon-search"></i></button>
                  </div>
               </form>
            </div>

         </div>
         <div class="wg-table table-all-user">

            <div class="table-responsive">
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Tên người dùng</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Trạng thái</th>
                    
                        <th class="text-center"></th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($users as $user)
                     <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="pname text-center">
                           <div class="image" style="display: inline-block;">

                              <img src="{{ asset('images/avatar/' . $user->image) }}" alt="" class="image"
                                 style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                           </div>
                           <div class="name" style="display: inline-block;">
                              <a href="#" class="body-title-2">{{$user->name}}</a>
                              <div class="text-tiny mt-3">{{$user->utype}}</div>
                           </div>
                        </td>
                        <td class="text-center">@if($user->customer)
                           {{ $user->customer->phone }}
                           @elseif($user->employee)
                           {{ $user->employee->phone }}
                           @else
                           <span class="text-muted">Không có</span>
                           @endif
                        </td>
                        <td class="text-center">{{$user->email}}</td>
                        <td class="text-center">@if($user->isLock)
                           <span class="badge bg-danger">Đã khóa</span>
                           @else
                           <span class="badge bg-success">Hoạt động</span>
                           @endif
                        </td>
                      
                        <td class="text-center">
                           <div class="list-icon-function" style="justify-content: center;">
                              <!-- <a href="#">
                                 <div class="item edit">
                                    <i class="icon-edit-3"></i>
                                 </div>
                              </a> -->
                              @if($user->utype !== 'ADM')
                              @if(!$user->isLock)
                              <form action="{{ route('admin.user.lock', $user->id) }}" method="POST" style="display:inline;">
                                 @csrf
                                 <button type="submit" class="item lock" style="background: none; border: none; padding: 0;" title="Khóa tài khoản">
                                    <i class="bi bi-lock-fill" style="color: #d97706; font-size: 18px;"></i>
                                 </button>
                              </form>
                              @else
                              <form action="{{ route('admin.user.unlock', $user->id) }}" method="POST" style="display:inline;">
                                 @csrf
                                 <button type="submit" class="item unlock" style="background: none; border: none; padding: 0;" title="Mở khóa tài khoản">
                                    <i class="bi bi-key-fill" style="color: #facc15; font-size: 18px;"></i>
                                 </button>
                              </form>
                              @endif
                              @endif
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>

         </div>
         <div class="divider"></div>
         <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

         </div>
      </div>
   </div>
</div>



@endsection