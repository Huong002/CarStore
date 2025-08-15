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
                           {!! $blog->content !!}
                        </div>
                     </div>
                  </div>

                  <div class="blog-profile box-center mb-lg-5 mb-4">
                     <div class="image-profile author-avatar-trigger" role="button" tabindex="0" style="cursor: pointer;">
                        <img src="{{ $blog->author->image ? asset('/images/avatar/'. $blog->author->image) : asset('images/inner-page/user/1.jpg') }}"
                           class="img-fluid blur-up lazyload" alt="{{ $blog->author->name }}">
                     </div>

                     <div class="image-name text-weight">
                        <h3 class="author-name-trigger" role="button" tabindex="0" style="cursor: pointer;">{{ $blog->author->name }}</h3>
                        <h6>{{ $blog->created_at->format('d M Y') }}</h6>
                     </div>
                  </div>

                  <!-- Comments Section -->
                  @if($blog->comments->count() > 0)
                  <div class="row g-2 mb-4">
                     <div class="col-12">
                        <h3>Bình luận ({{ $blog->comments->count() }})</h3>
                        @foreach($blog->comments as $comment)
                        <div class="comment-item border-bottom pb-3 mb-3 pt-3" id="comment-{{ $comment->id }}">
                           <div class="d-flex align-items-start gap-3">
                              <!-- User Avatar -->
                              <div class="comment-avatar flex-shrink-0">
                                 @if($comment->user && $comment->user->image)
                                 <img src="{{ asset('images/avatar/' . ($comment->user->image ??'default.jpg')) }}" alt="" class="image"
                                    style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                 @else
                                 <div class="default-avatar d-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                                    style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                                    {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                 </div>
                                 @endif
                              </div>

                              <!-- Comment Content -->
                              <div class="comment-content flex-grow-1">
                                 <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                       <h6 class="mb-1">{{ $comment->author_name }}</h6>
                                       <small class="text-muted">
                                          {{ $comment->created_at->format('d/m/Y H:i') }}
                                          @if($comment->updated_at && $comment->updated_at->gt($comment->created_at))
                                          <span class="text-info ms-1" title="Đã chỉnh sửa lúc {{ $comment->updated_at->format('d/m/Y H:i') }}">
                                             (đã chỉnh sửa)
                                          </span>
                                          @endif
                                       </small>
                                    </div>

                                    <!-- Edit/Delete Buttons -->
                                    @auth
                                    @if(Auth::id() === $comment->user_id)
                                    <div class="comment-actions">
                                       <div class="dropdown">
                                          <button class="btn btn-sm btn-outline-secondary dropdown-toggle comment-menu-btn"
                                             type="button"
                                             id="commentActions{{ $comment->id }}"
                                             data-bs-toggle="dropdown"
                                             data-comment-id="{{ $comment->id }}"
                                             aria-expanded="false">
                                             <i class="fas fa-ellipsis-h"></i>
                                          </button>
                                          <ul class="dropdown-menu comment-dropdown-menu"
                                             id="commentMenu{{ $comment->id }}"
                                             aria-labelledby="commentActions{{ $comment->id }}">
                                             <li>
                                                <button class="dropdown-item edit-comment-btn"
                                                   data-comment-id="{{ $comment->id }}"
                                                   data-comment-content="{{ $comment->content }}">
                                                   <i class="fas fa-edit me-1"></i> Sửa
                                                </button>
                                             </li>
                                             <li>
                                                <button class="dropdown-item text-danger delete-comment-btn"
                                                   data-comment-id="{{ $comment->id }}">
                                                   <i class="fas fa-trash me-1"></i> Xóa
                                                </button>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    @endif
                                    @endauth
                                 </div>

                                 <!-- Comment Text -->
                                 <div class="comment-text">
                                    <p class="mb-0" id="comment-text-{{ $comment->id }}">{{ $comment->content }}</p>
                                 </div>

                                 <!-- Edit Form (Hidden by default) -->
                                 <div class="edit-comment-form d-none" id="edit-form-{{ $comment->id }}">
                                    <form class="update-comment-form mt-2">
                                       @csrf
                                       @method('PUT')
                                       <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                       <div class="mb-2">
                                          <textarea name="content"
                                             class="form-control"
                                             rows="3"
                                             required>{{ $comment->content }}</textarea>
                                       </div>
                                       <div class="d-flex gap-2">
                                          <button type="submit" class="btn btn-primary btn-sm">
                                             <i class="fas fa-save me-1"></i> Lưu
                                          </button>
                                          <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn">
                                             <i class="fas fa-times me-1"></i> Hủy
                                          </button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
                  @endif

                  <!-- Comment Form -->
                  @auth
                  <form method="POST" action="{{ route('blog.comment', $blog->id) }}">
                     @csrf
                     <div class="row g-2">
                        <div class="col-12">
                           <div class="minus-spacing mb-2">
                              <h3>Leave Comments</h3>
                           </div>
                        </div>

                        <div class="col-12">
                           <p class="text-muted">Commenting as: <strong>{{ Auth::user()->name }}</strong></p>
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
                  @else
                  <div class="alert alert-info">
                     <p class="mb-0">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
                  </div>
                  @endauth

                  <!-- Custom Delete Confirmation Modal -->
                  <div id="deleteConfirmModal" class="custom-confirm-modal">
                     <div class="confirm-modal-content">
                        <div class="confirm-modal-header">
                           <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                           <span>Xác nhận xóa</span>
                        </div>
                        <div class="confirm-modal-body">
                           Bạn có chắc chắn muốn xóa bình luận này không?
                        </div>
                        <div class="confirm-modal-actions">
                           <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                              <i class="fas fa-trash me-1"></i> Xóa
                           </button>
                           <button type="button" class="btn btn-secondary btn-sm" id="cancelDeleteBtn">
                              <i class="fas fa-times me-1"></i> Hủy
                           </button>
                        </div>
                     </div>
                  </div>

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

<!-- Author Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="authorOffcanvas" aria-labelledby="authorOffcanvasLabel">
   <div class="offcanvas-header bg-primary text-white">
      <div class="d-flex align-items-center">
         <div class="me-3">
            <img src="{{ $blog->author->image ? asset('/images/avatar/'. $blog->author->image) : asset('images/inner-page/user/1.jpg') }}"
               class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $blog->author->name }}">
         </div>
         <div>
            <h5 class="offcanvas-title mb-0" id="authorOffcanvasLabel">{{ $blog->author->name }}</h5>
            <small class="text-light">{{ $blog->author->email }}</small>
         </div>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
   </div>

   <div class="offcanvas-body">
      <div class="mb-4">
         <h6 class="text-muted mb-3">
            <i class="fas fa-newspaper me-2"></i>Bài viết của tác giả ({{ $authorBlogs->count() }} bài)
         </h6>

         @if($authorBlogs->count() > 0)
         <div class="row g-3">
            @foreach($authorBlogs as $authorBlog)
            <div class="col-12">
               <div class="card border-0 shadow-sm h-100">
                  <div class="row g-0">
                     <div class="col-4">
                        <img src="{{ $authorBlog->featured_image ? asset('uploads/blogs/' . $authorBlog->featured_image) : asset('assets/images/inner-page/product/10.jpg') }}"
                           class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="{{ $authorBlog->title }}">
                     </div>
                     <div class="col-8">
                        <div class="card-body p-3">
                           <h6 class="card-title mb-2">
                              <a href="{{ route('blog.show', $authorBlog->slug) }}" class="text-decoration-none text-dark">
                                 {{ Str::limit($authorBlog->title, 60) }}
                              </a>
                           </h6>
                           <p class="card-text small text-muted mb-2">
                              {!! Str::limit(strip_tags($authorBlog->content), 80) !!}
                           </p>
                           <div class="d-flex justify-content-between align-items-center">
                              <small class="text-muted">
                                 <i class="fas fa-calendar me-1"></i>{{ $authorBlog->created_at->format('d/m/Y') }}
                              </small>
                              <span class="badge bg-light text-dark">{{ $authorBlog->category->name }}</span>
                           </div>
                           <div class="mt-2">
                              <small class="text-muted">
                                 <i class="fas fa-eye me-1"></i>{{ $authorBlog->views_count }} lượt xem
                              </small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>

         <div class="text-center mt-4">
            <small class="text-muted">
               <i class="fas fa-info-circle me-1"></i>Click vào bài viết để đọc chi tiết
            </small>
         </div>
         @else
         <div class="text-center py-4">
            <i class="fas fa-newspaper text-muted" style="font-size: 3rem;"></i>
            <h6 class="text-muted mt-3">Tác giả chưa có bài viết nào khác</h6>
            <p class="text-muted small mb-0">Hãy theo dõi để cập nhật bài viết mới từ tác giả này</p>
         </div>
         @endif
      </div>
   </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      console.log('=== Blog Detail Script Starting ===');

      // Get offcanvas element first
      const authorOffcanvasElement = document.getElementById('authorOffcanvas');
      console.log('Offcanvas element found:', authorOffcanvasElement);

      if (!authorOffcanvasElement) {
         console.error('ERROR: authorOffcanvas element not found!');
         return;
      }

      // Check if we're using Bootstrap 4 or 5
      const isBootstrap5 = typeof bootstrap !== 'undefined';
      const isBootstrap4 = typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined';
      const hasJQuery = typeof $ !== 'undefined';

      console.log('Bootstrap 5 available:', isBootstrap5);
      console.log('Bootstrap 4 (jQuery) available:', isBootstrap4);
      console.log('jQuery available:', hasJQuery);

      let authorOffcanvas = null;

      // Initialize offcanvas based on Bootstrap version
      if (isBootstrap5 && authorOffcanvasElement) {
         try {
            authorOffcanvas = new bootstrap.Offcanvas(authorOffcanvasElement);
            console.log('✓ Bootstrap 5 Offcanvas initialized successfully');
         } catch (e) {
            console.error('❌ Failed to initialize Bootstrap 5 Offcanvas:', e);
         }
      } else if (isBootstrap4 && authorOffcanvasElement) {
         console.log('✓ Using Bootstrap 4 compatible offcanvas');
      } else {
         console.log('⚠️ Using fallback offcanvas method');
      }

      // Function to show offcanvas
      function showAuthorOffcanvas() {
         console.log('🚀 Attempting to show offcanvas...');
         console.log('Element classes before:', authorOffcanvasElement.className);

         if (isBootstrap5 && authorOffcanvas) {
            console.log('Using Bootstrap 5 method');
            authorOffcanvas.show();
         } else if (hasJQuery && authorOffcanvasElement) {
            console.log('Using jQuery method');
            $(authorOffcanvasElement).addClass('show');
            $('body').addClass('offcanvas-backdrop');
         } else {
            console.log('Using vanilla JS method');
            authorOffcanvasElement.classList.add('show');
            document.body.classList.add('offcanvas-backdrop');
         }

         console.log('Element classes after:', authorOffcanvasElement.className);
         console.log('Body classes:', document.body.className);
      }

      // Function to hide offcanvas
      function hideAuthorOffcanvas() {
         console.log('🔽 Hiding offcanvas...');

         if (isBootstrap5 && authorOffcanvas) {
            authorOffcanvas.hide();
         } else if (hasJQuery && authorOffcanvasElement) {
            $(authorOffcanvasElement).removeClass('show');
            $('body').removeClass('offcanvas-backdrop');
         } else {
            authorOffcanvasElement.classList.remove('show');
            document.body.classList.remove('offcanvas-backdrop');
         }
      }

      // Get trigger elements
      const authorAvatar = document.querySelector('.author-avatar-trigger');
      const authorName = document.querySelector('.author-name-trigger');

      console.log('Avatar element found:', authorAvatar);
      console.log('Author name element found:', authorName);

      // Handle avatar click
      if (authorAvatar) {
         console.log('✓ Setting up avatar click handler');
         authorAvatar.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('👆 Avatar clicked!');
            showAuthorOffcanvas();
         });

         // Keyboard support for avatar
         authorAvatar.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
               e.preventDefault();
               console.log('⌨️ Avatar activated via keyboard');
               showAuthorOffcanvas();
            }
         });

         authorAvatar.setAttribute('title', 'Click để xem các bài viết khác của tác giả');
      } else {
         console.error('❌ Avatar element not found!');
      }

      // Handle author name click
      if (authorName) {
         console.log('✓ Setting up author name click handler');
         authorName.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('👆 Author name clicked!');
            showAuthorOffcanvas();
         });

         // Keyboard support for author name
         authorName.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
               e.preventDefault();
               console.log('⌨️ Author name activated via keyboard');
               showAuthorOffcanvas();
            }
         });

         authorName.setAttribute('title', 'Click để xem các bài viết khác của tác giả');
      } else {
         console.error('❌ Author name element not found!');
      }

      // Handle close button
      const closeButton = document.querySelector('#authorOffcanvas .btn-close, #authorOffcanvas .close');
      if (closeButton) {
         console.log('✓ Close button found, setting up handler');
         closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('❌ Close button clicked');
            hideAuthorOffcanvas();
         });
      }

      // Handle backdrop click (close when clicking outside)
      document.addEventListener('click', function(e) {
         // Check if offcanvas is open
         if (authorOffcanvasElement && authorOffcanvasElement.classList.contains('show')) {
            // Check if click is outside the offcanvas content
            if (!authorOffcanvasElement.contains(e.target) &&
               !e.target.closest('.author-avatar-trigger') &&
               !e.target.closest('.author-name-trigger') &&
               !e.target.closest('[data-bs-target="#authorOffcanvas"]')) {
               console.log('🔄 Backdrop clicked, closing offcanvas');
               hideAuthorOffcanvas();
            }
         }
      });

      // Handle Escape key to close offcanvas
      document.addEventListener('keydown', function(e) {
         if (e.key === 'Escape' && authorOffcanvasElement && authorOffcanvasElement.classList.contains('show')) {
            console.log('⌨️ Escape key pressed, closing offcanvas');
            hideAuthorOffcanvas();
         }
      });

      // ============= COMMENT MANAGEMENT FUNCTIONALITY =============

      // Dropdown Menu Handling (Fallback for Bootstrap)
      document.addEventListener('click', function(e) {
         if (e.target.closest('.comment-menu-btn')) {
            e.preventDefault();
            const button = e.target.closest('.comment-menu-btn');
            const commentId = button.getAttribute('data-comment-id');
            const menu = document.getElementById('commentMenu' + commentId);

            // Close all other dropdowns first
            document.querySelectorAll('.comment-dropdown-menu').forEach(otherMenu => {
               if (otherMenu !== menu) {
                  otherMenu.classList.remove('show');
               }
            });

            // Toggle current dropdown
            if (menu.classList.contains('show')) {
               menu.classList.remove('show');
            } else {
               menu.classList.add('show');
            }
         }

         // Close dropdowns when clicking outside
         else if (!e.target.closest('.comment-actions')) {
            document.querySelectorAll('.comment-dropdown-menu').forEach(menu => {
               menu.classList.remove('show');
            });
         }
      });

      // Edit Comment Function
      document.addEventListener('click', function(e) {
         if (e.target.closest('.edit-comment-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.edit-comment-btn');
            const commentId = btn.getAttribute('data-comment-id');
            const currentContent = btn.getAttribute('data-comment-content');

            // Hide comment text and show edit form
            document.getElementById('comment-text-' + commentId).style.display = 'none';
            const editFormContainer = document.getElementById('edit-form-' + commentId);
            editFormContainer.classList.remove('d-none');
            editFormContainer.style.display = 'block';

            // Focus on textarea
            const textarea = document.querySelector('#edit-form-' + commentId + ' textarea[name="content"]');
            textarea.focus();
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
         }
      });

      // Cancel Edit Function
      document.addEventListener('click', function(e) {
         if (e.target.closest('.cancel-edit-btn')) {
            e.preventDefault();
            const form = e.target.closest('.edit-comment-form');
            const commentId = form.querySelector('input[name="comment_id"]').value;

            // Show comment text and hide edit form
            document.getElementById('comment-text-' + commentId).style.display = 'block';
            const editFormContainer = document.getElementById('edit-form-' + commentId);
            editFormContainer.classList.add('d-none');
            editFormContainer.style.display = 'none';

            // Reset textarea content
            const originalContent = document.querySelector('.edit-comment-btn[data-comment-id="' + commentId + '"]').getAttribute('data-comment-content');
            form.querySelector('textarea[name="content"]').value = originalContent;
         }
      });

      // Update Comment Function
      document.addEventListener('submit', function(e) {
         if (e.target.classList.contains('update-comment-form')) {
            e.preventDefault();
            const form = e.target;
            const commentId = form.querySelector('input[name="comment_id"]').value;
            const newContent = form.querySelector('textarea[name="content"]').value;

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Đang lưu...';
            submitBtn.disabled = true;

            // AJAX Update Request
            fetch(`/blog/comment/${commentId}/update`, {
                  method: 'PUT',
                  headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                     'Accept': 'application/json',
                  },
                  body: JSON.stringify({
                     content: newContent
                  })
               })
               .then(response => response.json())
               .then(data => {
                  if (data.success) {
                     // Update comment text
                     document.getElementById('comment-text-' + commentId).textContent = newContent;
                     document.getElementById('comment-text-' + commentId).style.display = 'block';

                     // Update data attribute for future edits
                     document.querySelector('.edit-comment-btn[data-comment-id="' + commentId + '"]').setAttribute('data-comment-content', newContent);

                     // Hide edit form
                     const editFormContainer = document.getElementById('edit-form-' + commentId);
                     editFormContainer.classList.add('d-none');
                     editFormContainer.style.display = 'none';

                     // Show success message
                     showToast('Bình luận đã được cập nhật thành công!', 'success');

                     // Add "edited" indicator if not already present
                     const timeElement = document.querySelector('#comment-' + commentId + ' .text-muted');
                     if (!timeElement.querySelector('.text-info')) {
                        timeElement.innerHTML += ' <span class="text-info ms-1" title="Đã chỉnh sửa">(đã chỉnh sửa)</span>';
                     }
                  } else {
                     showToast(data.message || 'Có lỗi xảy ra khi cập nhật bình luận.', 'error');
                  }
               })
               .catch(error => {
                  console.error('Error:', error);
                  showToast('Có lỗi xảy ra khi cập nhật bình luận.', 'error');
               })
               .finally(() => {
                  // Reset button state
                  submitBtn.innerHTML = originalText;
                  submitBtn.disabled = false;
               });
         }
      });

      // Delete Comment Function
      document.addEventListener('click', function(e) {
         if (e.target.closest('.delete-comment-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.delete-comment-btn');
            const commentId = btn.getAttribute('data-comment-id');

            // Show custom confirm modal near the button
            showDeleteConfirmModal(btn, commentId);
         }
      });

      // Custom Delete Confirmation Modal Functions
      function showDeleteConfirmModal(triggerBtn, commentId) {
         const modal = document.getElementById('deleteConfirmModal');
         const btnRect = triggerBtn.getBoundingClientRect();

         // Position modal near the delete button
         modal.style.display = 'block';
         modal.style.position = 'fixed';
         modal.style.top = (btnRect.top - 80) + 'px';
         modal.style.left = (btnRect.left - 150) + 'px';
         modal.style.zIndex = '9999';

         // Add animation
         setTimeout(() => {
            modal.classList.add('show');
         }, 10);

         // Store comment ID for deletion
         modal.setAttribute('data-comment-id', commentId);

         // Close dropdown when modal opens
         document.querySelectorAll('.comment-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
         });
      }

      function hideDeleteConfirmModal() {
         const modal = document.getElementById('deleteConfirmModal');
         modal.classList.remove('show');
         setTimeout(() => {
            modal.style.display = 'none';
         }, 200);
      }

      // Confirm Delete Button
      document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
         const modal = document.getElementById('deleteConfirmModal');
         const commentId = modal.getAttribute('data-comment-id');

         // Hide modal immediately
         hideDeleteConfirmModal();

         // Proceed with deletion
         performCommentDeletion(commentId);
      });

      // Cancel Delete Button
      document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
         hideDeleteConfirmModal();
      });

      // Close modal when clicking outside
      document.addEventListener('click', function(e) {
         const modal = document.getElementById('deleteConfirmModal');
         if (modal.style.display === 'block' && !modal.contains(e.target) && !e.target.closest('.delete-comment-btn')) {
            hideDeleteConfirmModal();
         }
      });

      // Actual deletion function
      function performCommentDeletion(commentId) {
         // AJAX Delete Request
         fetch(`/blog/comment/${commentId}/delete`, {
               method: 'DELETE',
               headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                  'Accept': 'application/json',
               }
            })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  // Remove comment element with animation
                  const commentElement = document.getElementById('comment-' + commentId);
                  commentElement.style.transition = 'all 0.3s ease';
                  commentElement.style.opacity = '0';
                  commentElement.style.transform = 'translateX(-20px)';

                  setTimeout(() => {
                     commentElement.remove();

                     // Update comment count
                     const commentCountElement = document.querySelector('h3');
                     if (commentCountElement && commentCountElement.textContent.includes('Bình luận')) {
                        const currentCount = parseInt(commentCountElement.textContent.match(/\d+/)[0]);
                        const newCount = currentCount - 1;
                        if (newCount > 0) {
                           commentCountElement.textContent = `Bình luận (${newCount})`;
                        } else {
                           // Hide entire comment section if no comments left
                           const commentSection = document.querySelector('.row.g-2.mb-4');
                           if (commentSection) {
                              commentSection.style.display = 'none';
                           }
                        }
                     }
                  }, 300);

                  showToast('Bình luận đã được xóa thành công!', 'success');
               } else {
                  showToast(data.message || 'Có lỗi xảy ra khi xóa bình luận.', 'error');
               }
            })
            .catch(error => {
               console.error('Error:', error);
               showToast('Có lỗi xảy ra khi xóa bình luận.', 'error');
            });
      }

      // Toast notification function
      function showToast(message, type = 'info') {
         const toastContainer = document.getElementById('toast-container') || createToastContainer();
         const toast = document.createElement('div');
         toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0 mb-2`;
         toast.setAttribute('role', 'alert');
         toast.setAttribute('aria-live', 'assertive');
         toast.setAttribute('aria-atomic', 'true');

         toast.innerHTML = `
            <div class="d-flex">
               <div class="toast-body">
                  ${message}
               </div>
               <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
         `;

         toastContainer.appendChild(toast);

         // Show toast
         if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            // Auto remove after 5 seconds
            setTimeout(() => {
               if (toast.parentNode) {
                  toast.remove();
               }
            }, 5000);
         } else {
            // Fallback for older Bootstrap
            toast.style.display = 'block';
            setTimeout(() => {
               if (toast.parentNode) {
                  toast.remove();
               }
            }, 5000);
         }
      }

      function createToastContainer() {
         const container = document.createElement('div');
         container.id = 'toast-container';
         container.className = 'toast-container position-fixed top-0 end-0 p-3';
         container.style.zIndex = '9999';
         document.body.appendChild(container);
         return container;
      }

      console.log('=== Script setup complete ===');
   });
</script>

<style>
   /* Author Profile Hover Effect */
   .blog-profile .image-profile {
      transition: all 0.3s ease;
      border-radius: 50%;
      overflow: hidden;
      position: relative;
      cursor: pointer !important;
   }

   .blog-profile .image-profile:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
   }

   .blog-profile .image-profile::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 123, 255, 0.1);
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
   }

   .blog-profile .image-profile:hover::after {
      opacity: 1;
   }

   /* Author Profile Click Hint */
   .blog-profile .image-profile::before {
      content: '👤';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 1.5rem;
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: 1;
      pointer-events: none;
   }

   .blog-profile .image-profile:hover::before {
      opacity: 0.8;
   }

   /* Make sure the avatar is clickable */
   .author-avatar-trigger {
      cursor: pointer !important;
      position: relative;
      display: inline-block;
      transition: all 0.3s ease;
   }

   .author-avatar-trigger:focus {
      outline: 2px solid #007bff;
      outline-offset: 2px;
   }

   .author-avatar-trigger:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
   }

   /* Make author name clickable */
   .author-name-trigger {
      cursor: pointer !important;
      transition: all 0.3s ease;
      text-decoration: none !important;
      color: inherit;
   }

   .author-name-trigger:hover {
      color: #007bff !important;
      text-shadow: 0 1px 3px rgba(0, 123, 255, 0.2);
   }

   .author-name-trigger:focus {
      outline: 2px solid #007bff;
      outline-offset: 2px;
   }

   /* Bootstrap 4 compatible offcanvas styles */
   .offcanvas {
      position: fixed !important;
      top: 0 !important;
      bottom: 0 !important;
      right: 0 !important;
      z-index: 1055 !important;
      width: 400px !important;
      max-width: 400px !important;
      background-color: #fff !important;
      border-left: 1px solid #dee2e6 !important;
      transform: translateX(100%) !important;
      transition: transform 0.3s ease-in-out !important;
      overflow-y: auto !important;
      box-shadow: -0.5rem 0 1rem rgba(0, 0, 0, 0.15) !important;
   }

   .offcanvas.show {
      transform: translateX(0) !important;
      visibility: visible !important;
      display: block !important;
   }

   .offcanvas-end {
      right: 0 !important;
      left: auto !important;
   }

   .offcanvas-header {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      padding: 1rem !important;
      border-bottom: 1px solid #dee2e6 !important;
      background: linear-gradient(135deg, #007bff, #0056b3) !important;
      color: white !important;
   }

   .offcanvas-title {
      margin: 0 !important;
      font-size: 1.25rem !important;
      font-weight: 500 !important;
      color: white !important;
   }

   .offcanvas-body {
      padding: 1rem !important;
      flex-grow: 1 !important;
      overflow-y: auto !important;
      height: calc(100vh - 80px) !important;
   }

   .btn-close {
      background: transparent !important;
      border: 0 !important;
      font-size: 1.5rem !important;
      line-height: 1 !important;
      color: white !important;
      opacity: 0.8 !important;
      cursor: pointer !important;
      padding: 0 !important;
      margin: 0 !important;
      width: 1.5rem !important;
      height: 1.5rem !important;
   }

   .btn-close:hover {
      opacity: 1 !important;
   }

   .btn-close::before {
      content: "×" !important;
      font-size: 1.5rem !important;
      font-weight: bold !important;
   }

   /* Backdrop for Bootstrap 4 */
   body.offcanvas-backdrop::before {
      content: '' !important;
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      background-color: rgba(0, 0, 0, 0.5) !important;
      z-index: 1050 !important;
      display: block !important;
   }

   /* Offcanvas Styling */
   #authorOffcanvas .offcanvas-header {
      background: linear-gradient(135deg, #007bff, #0056b3);
   }

   #authorOffcanvas .card {
      transition: all 0.3s ease;
      cursor: pointer;
   }

   #authorOffcanvas .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
   }

   #authorOffcanvas .card-title a:hover {
      color: #007bff !important;
   }

   /* Badge hover effect */
   #authorOffcanvas .badge {
      transition: all 0.3s ease;
   }

   #authorOffcanvas .card:hover .badge {
      background-color: #007bff !important;
      color: white !important;
   }

   /* Responsive adjustments */
   @media (max-width: 768px) {
      .offcanvas {
         width: 90% !important;
         max-width: 90% !important;
      }

      #authorOffcanvas {
         width: 90% !important;
      }

      .blog-profile .image-profile:hover {
         transform: none;
      }
   }

   /* Loading animation for offcanvas */
   #authorOffcanvas .card {
      animation: fadeInUp 0.5s ease forwards;
   }

   @keyframes fadeInUp {
      from {
         opacity: 0;
         transform: translateY(20px);
      }

      to {
         opacity: 1;
         transform: translateY(0);
      }
   }

   /* Stagger animation for cards */
   #authorOffcanvas .card:nth-child(1) {
      animation-delay: 0.1s;
   }

   #authorOffcanvas .card:nth-child(2) {
      animation-delay: 0.2s;
   }

   #authorOffcanvas .card:nth-child(3) {
      animation-delay: 0.3s;
   }

   #authorOffcanvas .card:nth-child(4) {
      animation-delay: 0.4s;
   }

   #authorOffcanvas .card:nth-child(5) {
      animation-delay: 0.5s;
   }

   /* ======= COMMENT STYLES ======= */
   .comment-item {
      transition: all 0.3s ease;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1rem;
      background: #f8f9fa;
   }

   .comment-item:hover {
      background: #e9ecef;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
   }

   .comment-avatar img,
   .default-avatar {
      border: 2px solid #e9ecef;
      transition: all 0.3s ease;
   }

   .comment-avatar img:hover,
   .default-avatar:hover {
      border-color: #007bff;
      transform: scale(1.05);
   }

   .comment-actions .dropdown-toggle {
      border: none;
      background: transparent;
      color: #6c757d;
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
   }

   .comment-actions .dropdown-toggle:hover {
      background: #e9ecef;
      color: #495057;
   }

   .comment-actions .dropdown-menu {
      position: absolute;
      top: 100%;
      right: 0;
      z-index: 1000;
      min-width: 120px;
      padding: 0.25rem 0;
      margin: 0.125rem 0 0;
      background-color: #fff;
      border: 1px solid #dee2e6;
      border-radius: 0.375rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      display: none;
   }

   .comment-actions .dropdown-menu.show {
      display: block;
   }

   .comment-actions .dropdown-item {
      font-size: 0.875rem;
      padding: 0.5rem 1rem;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
   }

   .comment-actions .dropdown-item:hover {
      background: #f8f9fa;
   }

   .comment-actions .dropdown-item.text-danger:hover {
      background: #f8d7da;
      color: #721c24;
   }

   .edit-comment-form {
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      padding: 1rem;
      margin-top: 0.5rem;
   }

   .edit-comment-form.d-none {
      display: none !important;
      height: 0 !important;
      margin: 0 !important;
      padding: 0 !important;
      overflow: hidden !important;
      border: none !important;
   }

   /* Ensure comment container doesn't have extra spacing */
   .comment-content {
      transition: all 0.3s ease;
   }

   .comment-text {
      margin-bottom: 0;
   }

   .comment-text p {
      margin-bottom: 0 !important;
   }

   /* ======= CUSTOM DELETE CONFIRMATION MODAL ======= */
   .custom-confirm-modal {
      position: fixed;
      z-index: 9999;
      display: none;
      opacity: 0;
      transform: scale(0.9) translateY(-10px);
      transition: all 0.2s ease-in-out;
   }

   .custom-confirm-modal.show {
      opacity: 1;
      transform: scale(1) translateY(0);
   }

   .confirm-modal-content {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      border: 1px solid #e9ecef;
      min-width: 280px;
      max-width: 320px;
      overflow: hidden;
   }

   .confirm-modal-header {
      background: linear-gradient(135deg, #fff3cd, #ffeaa7);
      padding: 12px 16px;
      border-bottom: 1px solid #f1c40f;
      font-weight: 600;
      font-size: 14px;
      color: #856404;
      display: flex;
      align-items: center;
   }

   .confirm-modal-body {
      padding: 16px;
      font-size: 14px;
      color: #495057;
      line-height: 1.4;
   }

   .confirm-modal-actions {
      padding: 12px 16px;
      background: #f8f9fa;
      display: flex;
      gap: 8px;
      justify-content: flex-end;
   }

   .confirm-modal-actions .btn {
      font-size: 12px;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.2s ease;
   }

   .confirm-modal-actions .btn-danger {
      background: #dc3545;
      border: none;
      color: white;
   }

   .confirm-modal-actions .btn-danger:hover {
      background: #c82333;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
   }

   .confirm-modal-actions .btn-secondary {
      background: #6c757d;
      border: none;
      color: white;
   }

   .confirm-modal-actions .btn-secondary:hover {
      background: #5a6268;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
   }

   /* Arrow pointing to the delete button */
   .custom-confirm-modal::after {
      content: '';
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 0;
      border-left: 8px solid transparent;
      border-right: 8px solid transparent;
      border-top: 8px solid #fff;
      filter: drop-shadow(0 3px 3px rgba(0, 0, 0, 0.1));
   }

   /* Responsive adjustments */
   @media (max-width: 768px) {
      .confirm-modal-content {
         min-width: 250px;
         max-width: 280px;
      }

      .confirm-modal-header {
         padding: 10px 12px;
         font-size: 13px;
      }

      .confirm-modal-body {
         padding: 12px;
         font-size: 13px;
      }

      .confirm-modal-actions {
         padding: 10px 12px;
      }

      .confirm-modal-actions .btn {
         font-size: 11px;
         padding: 5px 10px;
      }
   }

   .edit-comment-form textarea {
      resize: vertical;
      min-height: 80px;
   }

   .edit-comment-form .btn {
      font-size: 0.875rem;
      padding: 0.375rem 0.75rem;
   }

   /* Toast positioning */
   .toast-container {
      z-index: 9999 !important;
   }

   .toast {
      min-width: 300px;
   }

   /* Comment edited indicator */
   .comment-content .text-info {
      font-size: 0.75rem;
      font-style: italic;
   }

   /* Comment avatar styling */
   .comment-avatar {
      position: relative;
   }

   .comment-avatar::after {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      border-radius: 50%;
      background: linear-gradient(45deg, transparent, transparent);
      z-index: -1;
      transition: all 0.3s ease;
   }

   .comment-item:hover .comment-avatar::after {
      background: linear-gradient(45deg, #007bff, #0056b3);
   }

   /* Responsive comment layout */
   @media (max-width: 768px) {
      .comment-item {
         padding: 0.75rem;
      }

      .comment-avatar img,
      .default-avatar {
         width: 32px !important;
         height: 32px !important;
         font-size: 14px !important;
      }

      .comment-actions .dropdown-toggle {
         padding: 0.125rem 0.25rem;
         font-size: 0.75rem;
      }

      .edit-comment-form {
         padding: 0.75rem;
      }

      .toast-container {
         left: 1rem;
         right: 1rem;
         width: auto;
      }

      .toast {
         min-width: auto;
      }
   }
</style>

@endsection