@extends('layouts.blog')

@section('content')
<div class="container py-5">
   <!-- Page Header -->
   <div class="row mb-5">
      <div class="col-12 text-center">
         <h1 class="display-4 mb-3">Blog Ô Tô</h1>
         <p class="lead text-muted">Tin tức, đánh giá và kiến thức về thế giới ô tô</p>
      </div>
   </div>

   <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
         <!-- Search & Filter -->
         <div class="row mb-4">
            <div class="col-md-8">
               <form method="GET" action="{{ route('blog.index') }}" class="d-flex">
                  <input type="text" name="search" class="form-control me-2"
                     placeholder="Tìm kiếm bài viết..." value="{{ $search }}">
                  <button type="submit" class="btn btn-primary">Tìm</button>
               </form>
            </div>
            <div class="col-md-4">
               <form method="GET" action="{{ route('blog.index') }}">
                  <select name="category" class="form-select" onchange="this.form.submit()">
                     <option value="">Tất cả danh mục</option>
                     @foreach($categories as $cat)
                     <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }} ({{ $cat->blogs_count }})
                     </option>
                     @endforeach
                  </select>
                  <input type="hidden" name="search" value="{{ $search }}">
               </form>
            </div>
         </div>

         <!-- Blog Posts Grid -->
         <div class="row">
            @forelse($blogs as $blog)
            <div class="col-md-6 mb-4">
               <div class="card h-100 shadow-sm">
                  @if($blog->featured_image)
                  <img src="{{ asset('uploads/blogs/' . $blog->featured_image) }}"
                     class="card-img-top" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                  @endif
                  <div class="card-body d-flex flex-column">
                     <div class="mb-2">
                        <span class="badge bg-primary">{{ $blog->category->name }}</span>
                        <small class="text-muted ms-2">
                           <i class="bi bi-eye"></i> {{ $blog->views_count }} lượt xem
                        </small>
                     </div>
                     <h5 class="card-title">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none">
                           {{ $blog->title }}
                        </a>
                     </h5>
                     <p class="card-text text-muted">
                        {{ Str::limit(strip_tags($blog->content), 120) }}
                     </p>
                     <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                           <small class="text-muted">
                              <i class="bi bi-person"></i> {{ $blog->author->name }}
                              <br>
                              <i class="bi bi-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}
                           </small>
                           <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">
                              Đọc thêm
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @empty
            <div class="col-12">
               <div class="text-center py-5">
                  <h4>Không tìm thấy bài viết nào</h4>
                  <p class="text-muted">Hãy thử tìm kiếm với từ khóa khác.</p>
               </div>
            </div>
            @endforelse
         </div>

         <!-- Pagination -->
         <div class="d-flex justify-content-center">
            {{ $blogs->appends(request()->query())->links() }}
         </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
         <!-- Recent Posts -->
         <div class="card mb-4">
            <div class="card-header">
               <h5 class="mb-0">Bài viết mới nhất</h5>
            </div>
            <div class="card-body">
               @foreach($recentBlogs as $recent)
               <div class="d-flex mb-3">
                  @if($recent->featured_image)
                  <img src="{{ asset('uploads/blogs/' . $recent->featured_image) }}"
                     class="me-3" alt="{{ $recent->title }}"
                     style="width: 60px; height: 60px; object-fit: cover;">
                  @endif
                  <div class="flex-grow-1">
                     <h6 class="mb-1">
                        <a href="{{ route('blog.show', $recent->slug) }}" class="text-decoration-none">
                           {{ Str::limit($recent->title, 50) }}
                        </a>
                     </h6>
                     <small class="text-muted">{{ $recent->created_at->format('d/m/Y') }}</small>
                  </div>
               </div>
               @if(!$loop->last)
               <hr>@endif
               @endforeach
            </div>
         </div>

         <!-- Popular Posts -->
         <div class="card mb-4">
            <div class="card-header">
               <h5 class="mb-0">Bài viết phổ biến</h5>
            </div>
            <div class="card-body">
               @foreach($popularBlogs as $popular)
               <div class="d-flex mb-3">
                  @if($popular->featured_image)
                  <img src="{{ asset('uploads/blogs/' . $popular->featured_image) }}"
                     class="me-3" alt="{{ $popular->title }}"
                     style="width: 60px; height: 60px; object-fit: cover;">
                  @endif
                  <div class="flex-grow-1">
                     <h6 class="mb-1">
                        <a href="{{ route('blog.show', $popular->slug) }}" class="text-decoration-none">
                           {{ Str::limit($popular->title, 50) }}
                        </a>
                     </h6>
                     <small class="text-muted">
                        <i class="bi bi-eye"></i> {{ $popular->views_count }} lượt xem
                     </small>
                  </div>
               </div>
               @if(!$loop->last)
               <hr>@endif
               @endforeach
            </div>
         </div>

         <!-- Categories -->
         <div class="card">
            <div class="card-header">
               <h5 class="mb-0">Danh mục</h5>
            </div>
            <div class="card-body">
               @foreach($categories as $category)
               <div class="d-flex justify-content-between align-items-center mb-2">
                  <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none">
                     {{ $category->name }}
                  </a>
                  <span class="badge bg-secondary">{{ $category->blogs_count }}</span>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection