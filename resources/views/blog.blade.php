@extends('layouts.blog')
@section('content')

<!-- Blog Section Start -->
<section id="portfolio" class="left-sidebar-section masonary-blog-section section-b-space">
   <div class="container">
      <div class="row g-4">
         <div class="col-lg-9 col-md-7 order-md-1 ratio3_2">
            <div class="row g-4">
               @forelse($blogs as $blog)
               <div class="col-lg-4 col-md-6 col-grid-box">
                  <div class="card blog-categority">
                     <a href="{{ route('blog.show', $blog->slug) }}" class="blog-img">
                        <img src="{{ $blog->featured_image ? asset('uploads/blogs/' . $blog->featured_image) : asset('assets_v2/images/blog/sample.jpg') }}" alt="{{ $blog->title }}"
                           class="card-img-top bg-img">
                     </a>
                     <div class="card-body">
                        <h5>{{ $blog->category->name }}</h5>
                        <a href="{{ route('blog.show', $blog->slug) }}">
                           <h2 class="card-title">{{ Str::limit($blog->title, 80) }}</h2>
                        </a>
                        <div class="blog-profile">
                           <div class="image-name">
                              <h3>{{ $blog->author->name }}</h3>
                              <h6>{{ $blog->created_at->format('d M Y') }}</h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @empty
               <div class="col-12">
                  <div class="text-center py-5">
                     <h4>Không có bài viết nào</h4>
                     <p>Hãy thử tìm kiếm với từ khóa khác.</p>
                  </div>
               </div>
               @endforelse
            </div>
         </div>
         <div class="col-lg-3 col-md-5">
            <div class="left-side">
               <!-- Search Bar Start -->
               <div class="search-section">
                  <form method="GET" action="{{ route('blog.index') }}">
                     <div class="input-group search-bar">
                        <input type="search" name="search" class="form-control search-input"
                           placeholder="Search" value="{{ request('search') }}">
                        <button type="submit" class="input-group-text search-button" id="basic-addon3">
                           <i class="fas fa-search text-color"></i>
                        </button>
                     </div>
                  </form>
               </div>
               <!-- Search Bar End -->

               <!-- Popular Post Start -->
               <div class="popular-post mt-4">
                  <div class="popular-title">
                     <h3>Popular Posts</h3>
                  </div>

                  @foreach($popularBlogs as $index => $popular)
                  <div class="popular-image">
                     <div class="popular-number">
                        <h4 class="theme-color">{{ sprintf('%02d', $index + 1) }}</h4>
                     </div>
                     <div class="popular-contain">
                        <a href="{{ route('blog.show', $popular->slug) }}" class="text-decoration-none text-dark">
                           <h3>{{ Str::limit($popular->title, 60) }}</h3>
                           <p class="font-light mb-1"><span>{{ $popular->author->name }}</span> in <span>{{ $popular->category->name }}</span></p>
                           <div class="review-box">
                              <span class="font-light clock-time"><i data-feather="clock"></i>{{ $popular->created_at->diffForHumans() }}</span>
                              <span class="font-light eye-icon"><i data-feather="eye"></i>{{ $popular->views_count }}</span>
                           </div>
                        </a>
                     </div>
                  </div>
                  @endforeach
               </div>
               <!-- Popular Post End -->

               <!-- Category section Start -->
               <div class="category-section popular-post mt-4">
                  <div class="popular-title">
                     <h3>Category</h3>
                  </div>
                  <ul>
                     @foreach($categories as $category)
                     <li class="category-box">
                        <a href="{{ route('blog.category', $category->slug) }}">
                           <div class="category-product">
                              <div class="cate-shape">
                                 <i class="fas fa-car text-color"></i>
                              </div>

                              <div class="cate-contain">
                                 <h5 class="text-color">{{ $category->name }}</h5>
                              </div>
                           </div>
                        </a>
                     </li>
                     @endforeach
                  </ul>
               </div>
               <!-- Category section End -->
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Blog Section End -->
@endsection