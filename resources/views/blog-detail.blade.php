@extends('layouts.blog')
@section('content')

<!-- Details Blog Section Start -->
<section class="masonary-blog-section">
   <div class="container">
      <div class="row g-4">
         <div class="col-lg-9 col-md-8 order-md-1 ratio_square">
            <div class="row g-4">
               <div class="col-12">
                  <div class="blog-details">
                     <div class="blog-image-box">
                        <img src="{{ $blog->featured_image ? asset('uploads/blogs/' . $blog->featured_image) : asset('assets/images/inner-page/product/10.jpg') }}"
                           alt="{{ $blog->title }}" class="card-img-top">
                        <div class="blog-title">
                           <div>
                              <div class="social-media media-center">
                                 <a href="https://www.facebook.com/" target="new">
                                    <div class="social-icon-box social-color">
                                       <i class="fab fa-facebook-f"></i>
                                    </div>
                                 </a>
                                 <a href="https://twitter.com/" target="new">
                                    <div class="social-icon-box social-color">
                                       <i class="fab fa-twitter"></i>
                                    </div>
                                 </a>
                                 <a href="https://in.pinterest.com/" target="new">
                                    <div class="social-icon-box social-color">
                                       <i class="fab fa-pinterest-p"></i>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="blog-detail-contain">
                        <span class="font-light">{{ $blog->created_at->format('F d Y') }}</span>
                        <h2 class="card-title">{{ $blog->title }}</h2>
                        <div class="font-light firt-latter">
                           {!! nl2br(e($blog->content)) !!}
                        </div>
                     </div>
                  </div>

                  <div class="blog-profile box-center mb-lg-5 mb-4">
                     <div class="image-profile">
                        <img src="{{ asset('assets/images/inner-page/review-image/2.jpg') }}"
                           class="img-fluid blur-up lazyload" alt="">
                     </div>

                     <div class="image-name text-weight">
                        <h3>{{ $blog->author->name }}</h3>
                        <h6>{{ $blog->created_at->format('d M Y') }}</h6>
                     </div>
                  </div>

                  <!-- Comments Section -->
                  @if($blog->comments->count() > 0)
                  <div class="row g-2 mb-4">
                     <div class="col-12">
                        <h3>Bình luận ({{ $blog->comments->count() }})</h3>
                        @foreach($blog->comments as $comment)
                        <div class="comment-item border-bottom pb-3 mb-3">
                           <div class="d-flex justify-content-between">
                              <h6 class="mb-1">{{ $comment->author_name }}</h6>
                              <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                           </div>
                           <p class="mb-0">{{ $comment->content }}</p>
                        </div>
                        @endforeach
                     </div>
                  </div>
                  @endif

                  <!-- Comment Form -->
                  <form method="POST" action="{{ route('blog.comment', $blog->id) }}">
                     @csrf
                     <div class="row g-2">
                        <div class="col-12">
                           <div class="minus-spacing mb-2">
                              <h3>Leave Comments</h3>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <label for="author_name" class="form-label">Tên của bạn</label>
                           <input type="text" name="author_name" class="form-control" id="author_name"
                              placeholder="Nhập tên của bạn" required="" value="{{ old('author_name') }}">
                        </div>
                        <div class="col-lg-6">
                           <label for="author_email" class="form-label">Email</label>
                           <input type="email" name="author_email" class="form-control" id="author_email"
                              placeholder="example@example.com" required="" value="{{ old('author_email') }}">
                        </div>

                        <div class="col-12">
                           <label for="content" class="form-label">Bình luận</label>
                           <textarea rows="3" name="content" class="form-control" id="content"
                              placeholder="Để lại bình luận của bạn..." required="">{{ old('content') }}</textarea>
                        </div>

                        <div class="col-12">
                           <button type="submit" class="btn btn-solid-default btn-spacing mt-2">Gửi bình luận</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>

         <div class="col-lg-3 col-md-4">
            <div class="left-side">
               <!-- Search Bar Start -->
               <div class="search-section">
                  <div class="input-group search-bar">
                     <input type="search" class="form-control search-input" placeholder="Search">
                     <button class="input-group-text search-button" id="basic-addon3">
                        <i class="fas fa-search text-color"></i>
                     </button>
                  </div>
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
<!-- Details Blog Section End -->


@endsection