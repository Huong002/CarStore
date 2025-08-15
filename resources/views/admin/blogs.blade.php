@extends('layouts.admin')
@section('content')


<div class="main-content-inner">
   <div class="main-content-wrap">
      <div class="flex items-center flex-wrap justify-between gap20 mb-27">
         <h3>Danh sách bài viết</h3>
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
               <div class="text-tiny">Danh sách bài viết</div>
            </li>
         </ul>
      </div>

      <div class="wg-box">
         <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
               <form class="form-search">
                  <fieldset class="name">
                     <input type="text" placeholder="Tìm kiếm bài viết..." class="" name="search"
                        tabindex="2" value="{{request('search')}}" aria-required="true" required="">
                  </fieldset>
                  <div class="button-submit">
                     <button class="" type="submit"><i class="icon-search"></i></button>
                  </div>
               </form>
            </div>
            <a class="tf-button style-1 w208" href="{{route('admin.blogs.add')}}"><i
                  class="icon-plus"></i>Thêm bài viết</a>
         </div>
         <div class="table-responsive">
            <table class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th class="text-center" style="white-space:nowrap;">STT</th>
                     <th style="min-width: 200px; text-align:left;">Tiêu đề</th>
                     <th class="text-center" style="min-width: 120px;">Tác giả</th>
                     <th class="text-center" style="min-width: 120px;">Danh mục</th>
                     <th class="text-center" style="white-space:nowrap;">Trạng thái</th>
                     <th class="text-center" style="white-space:nowrap;">Lượt xem</th>
                     <th class="text-center" style="white-space:nowrap;">Ngày tạo</th>
                     <th class="text-center" style="white-space:nowrap;">Thao tác</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($blogs as $blog)
                  <tr>
                     <td class="text-center" style="white-space:nowrap;">{{$loop->iteration}}</td>
                     <td class="pname" style="white-space:nowrap; text-align:left;">
                        <div class="image" style="display:inline-block;vertical-align:middle;">
                           @if($blog->featured_image)
                           <img src="{{asset('uploads/blogs/'.$blog->featured_image)}}" alt="{{$blog->title}}" class="image" style="width: 50px; height: 50px; object-fit: cover;">
                           @else
                           <img src="{{asset('assets/images/blog/default.jpg')}}" alt="{{$blog->title}}" class="image" style="width: 50px; height: 50px; object-fit: cover;">
                           @endif
                        </div>
                        <div class="name" style="display:inline-block;vertical-align:middle;">
                           <a href="javascript:void(0)"
                              class="body-title-2 view-content"
                              data-bs-toggle="offcanvas"
                              data-bs-target="#blogContent"
                              data-content="{{ $blog->content }}"
                              data-title="{{ $blog->title }}"
                              style="text-align:left; display:block; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
                              title="{{$blog->title}}">
                              {{ \Illuminate\Support\Str::limit($blog->title, 20) }}
                           </a>
                           <div class="text-tiny mt-3" style="text-align:left; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{$blog->slug}}">
                              {{ \Illuminate\Support\Str::limit($blog->slug, 25) }}
                           </div>
                        </div>
                     </td>
                     <td class="text-center" style="white-space:nowrap;">
                        {{$blog->author ? $blog->author->name : 'N/A'}}
                     </td>
                     <td class="text-center" style="white-space:nowrap;">
                        {{$blog->category ? $blog->category->name : 'N/A'}}
                     </td>
                     <td class="text-center" style="white-space:nowrap;">
                        {!! $blog->status == 'published'
                        ? '<span class="badge bg-success">Đã xuất bản</span>'
                        : '<span class="badge bg-warning">Bản nháp</span>' !!}
                     </td>
                     <td class="text-center" style="white-space:nowrap;">{{number_format($blog->views_count)}}</td>
                     <td class="text-center" style="white-space:nowrap;">{{$blog->created_at->format('d/m/Y')}}</td>
                     <td class="text-center" style="white-space:nowrap;">
                        <div class="list-icon-function d-flex justify-content-center align-items-center gap-4">
                           <a href="{{ route('blog.show', $blog->slug) }}" target="_blank">
                              <div class="item view">
                                 <i class="icon-eye"></i>
                              </div>
                           </a>
                           <a href="{{ route('admin.blogs.edit', ['id' => $blog->id]) }}">
                              <div class="item edit">
                                 <i class="icon-edit-3"></i>
                              </div>
                           </a>
                           <form action="{{ route('admin.blogs.delete', ['id' => $blog->id]) }}" method="POST">
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
         <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">



         </div>
      </div>
   </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="blogContent" aria-labelledby="blogContentLabel">
   <div class="offcanvas-header">
      <h5 id="blogContentLabel">Nội dung bài viết</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
   </div>
   <div class="offcanvas-body" id="blogContentBody">
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
            title: 'Bạn có chắc chắn muốn xóa bài viết này?',
            text: 'Bạn muốn xóa bài viết này?',
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
<script>
   $(function() {
      // Existing delete handler code...

      $('.view-content').on('click', function() {
         const content = $(this).data('content');
         const title = $(this).data('title');

         $('#blogContentLabel').text(title);
         $('#blogContentBody').html(content); 
      });
   });
</script>
@endpush