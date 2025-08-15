<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BlogController extends Controller
{
   /**
    * Hiển thị danh sách tất cả blogs trong blog.blade.php
    */
   public function index(Request $request)
   {
      // Lấy tham số tìm kiếm và category từ request
      $search = $request->get('search');
      $categoryId = $request->get('category');

      // Query blogs với các điều kiện
      $blogsQuery = Blog::with(['author', 'category', 'comments'])
         ->where('status', 'published')
         ->orderBy('created_at', 'desc');

      // Tìm kiếm theo title hoặc content
      if ($search) {
         $blogsQuery->where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
               ->orWhere('content', 'like', '%' . $search . '%');
         });
      }

      // Lọc theo category
      if ($categoryId) {
         $blogsQuery->where('category_id', $categoryId);
      }

      // Lấy tất cả blogs (có thể phân trang sau)
      $blogs = $blogsQuery->get();

      // Lấy các category để hiển thị
      $categories = BlogCategory::withCount('blogs')->orderBy('name')->get();

      // Lấy các blog phổ biến (popular posts)
      $popularBlogs = Blog::with(['author', 'category'])
         ->where('status', 'published')
         ->orderBy('views_count', 'desc')
         ->limit(4)
         ->get();

      return view('blog', compact('blogs', 'categories', 'popularBlogs', 'search', 'categoryId'));
   }

   /**
    * Hiển thị chi tiết một blog trong blog-detail.blade.php
    */
   public function show($slug)
   {
      // Lấy blog theo slug
      $blog = Blog::with(['author', 'category', 'comments.user'])
         ->where('slug', $slug)
         ->where('status', 'published')
         ->firstOrFail();

      // Tăng view count
      $blog->increment('views_count');

      // Lấy các blog phổ biến (popular posts cho sidebar)
      $popularBlogs = Blog::with(['author', 'category'])
         ->where('status', 'published')
         ->where('id', '!=', $blog->id)
         ->orderBy('views_count', 'desc')
         ->limit(4)
         ->get();

      // Lấy categories cho sidebar
      $categories = BlogCategory::orderBy('name')->get();

      // Lấy các bài viết khác của cùng tác giả
      $authorBlogs = Blog::with(['category'])
         ->where('author_id', $blog->author_id)
         ->where('id', '!=', $blog->id)
         ->where('status', 'published')
         ->orderBy('created_at', 'desc')
         ->limit(10)
         ->get();

      return view('blog-detail', compact('blog', 'popularBlogs', 'categories', 'authorBlogs'));
   }

   /**
    * Hiển thị blogs theo category (vẫn dùng blog.blade.php)
    */
   public function category($slug)
   {
      // Lấy category theo slug
      $category = BlogCategory::where('slug', $slug)->firstOrFail();

      // Lấy blogs thuộc category này
      $blogs = Blog::with(['author', 'category', 'comments'])
         ->where('category_id', $category->id)
         ->where('status', 'published')
         ->orderBy('created_at', 'desc')
         ->get();

      // Lấy tất cả categories
      $categories = BlogCategory::withCount('blogs')->orderBy('name')->get();

      // Lấy các blog phổ biến
      $popularBlogs = Blog::with(['author', 'category'])
         ->where('status', 'published')
         ->orderBy('views_count', 'desc')
         ->limit(4)
         ->get();

      return view('blog', compact('blogs', 'categories', 'popularBlogs', 'category'));
   }

   /**
    * Thêm comment cho blog (cho customer)
    */
   public function addComment(Request $request, $blogId)
   {
      // Kiểm tra user đã đăng nhập chưa
      if (!Auth::check()) {
         return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận');
      }

      $request->validate([
         'content' => 'required|string'
      ]);

      $blog = Blog::findOrFail($blogId);
      $user = Auth::user();

      BlogComment::create([
         'blog_id' => $blog->id,
         'author_name' => $user->name,
         'author_email' => $user->email,
         'content' => $request->content,
         'user_id' => $user->id
      ]);

      return redirect()->back()->with('success', 'Bình luận của bạn đã được thêm thành công!');
   }

   /**
    * Cập nhật comment
    */
   public function updateComment(Request $request, $commentId)
   {
      try {
         // Kiểm tra user đã đăng nhập
         if (!Auth::check()) {
            return response()->json([
               'success' => false,
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'
            ], 401);
         }

         $request->validate([
            'content' => 'required|string|max:1000'
         ]);

         $comment = BlogComment::findOrFail($commentId);

         // Kiểm tra quyền sở hữu comment
         if ($comment->user_id !== Auth::id()) {
            return response()->json([
               'success' => false,
               'message' => 'Bạn không có quyền chỉnh sửa bình luận này.'
            ], 403);
         }

         // Cập nhật comment
         $comment->update([
            'content' => $request->content,
            'updated_at' => now()
         ]);

         return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được cập nhật thành công!',
            'data' => [
               'id' => $comment->id,
               'content' => $comment->content,
               'updated_at' => $comment->updated_at->format('d/m/Y H:i')
            ]
         ]);
      } catch (ValidationException $e) {
         return response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ.',
            'errors' => $e->errors()
         ], 422);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy bình luận.'
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật bình luận.'
         ], 500);
      }
   }

   /**
    * Xóa comment
    */
   public function deleteComment($commentId)
   {
      try {
         // Kiểm tra user đã đăng nhập
         if (!Auth::check()) {
            return response()->json([
               'success' => false,
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'
            ], 401);
         }

         $comment = BlogComment::findOrFail($commentId);

         // Kiểm tra quyền sở hữu comment
         if ($comment->user_id !== Auth::id()) {
            return response()->json([
               'success' => false,
               'message' => 'Bạn không có quyền xóa bình luận này.'
            ], 403);
         }

         // Xóa comment
         $comment->delete();

         return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được xóa thành công!'
         ]);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy bình luận.'
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi xóa bình luận.'
         ], 500);
      }
   }


   // for admin
   public function blogs(Request $request)
   {
      // Lấy tham số tìm kiếm và category từ request
      $search = $request->get('search');
      $categoryId = $request->get('category');

      // Query blogs với các điều kiện
      $blogsQuery = Blog::with(['author', 'category', 'comments'])
         ->where('status', 'published')
         ->orderBy('created_at', 'desc');

      // Tìm kiếm theo title hoặc content
      if ($search) {
         $blogsQuery->where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
               ->orWhere('content', 'like', '%' . $search . '%');
         });
      }

      // Lấy tất cả blogs (có thể phân trang sau)
      $blogs = $blogsQuery->get();

      // Lấy các category để hiển thị
      $categories = BlogCategory::withCount('blogs')->orderBy('name')->get();

      // Lấy các blog phổ biến (popular posts)
      $popularBlogs = Blog::with(['author', 'category'])
         ->where('status', 'published')
         ->orderBy('views_count', 'desc')
         ->limit(4)
         ->get();

      return view('admin.blogs', compact('blogs', 'categories', 'popularBlogs', 'search', 'categoryId'));
   }
   public function blogs_add()
   {
      $categories = BlogCategory::orderBy('name')->get();
      return view('admin.blog-add', compact('categories'));
   }
   public function blogs_store(Request $request)
   {
      $request->validate([
         'title' => 'required|string|max:255',
         'slug' => 'required|string|unique:blogs,slug|max:255',
         'content' => 'required|string',
         'category_id' => 'required|exists:blog_categories,id',
         'status' => 'required|in:draft,published',
         'featured_image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
      ]);

      $blog = new Blog();
      $blog->title = $request->title;
      $blog->slug = Str::slug($request->slug);
      $blog->content = $request->content;
      $blog->category_id = $request->category_id;
      $blog->status = $request->status;
      $blog->author_id = Auth::user()->id; // Lấy ID của user hiện tại
      $blog->views_count = 0;

      // Xử lý upload ảnh đại diện
      if ($request->hasFile('featured_image')) {
         $image = $request->file('featured_image');
         $file_extension = $image->extension();
         $file_name = Carbon::now()->timestamp . '_blog.' . $file_extension;
         $destinationPath = public_path('uploads/blogs');

         if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
         }

         $image->move($destinationPath, $file_name);
         $blog->featured_image = $file_name;
      }

      $blog->save();

      return redirect()->route('admin.blogs')->with('status', 'Thêm bài viết thành công!');
   }

   public function blogs_edit($id)
   {
      $blog = Blog::with(['category'])->findOrFail($id);
      $categories = BlogCategory::orderBy('name')->get();
      return view('admin.blog-edit', compact('blog', 'categories'));
   }

   public function blogs_update(Request $request, $id)
   {
      $request->validate([
         'title' => 'required|string|max:255',
         'slug' => 'required|string|unique:blogs,slug,' . $id . '|max:255',
         'content' => 'required|string',
         'category_id' => 'required|exists:blog_categories,id',
         'status' => 'required|in:draft,published',
         'featured_image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
      ]);

      $blog = Blog::findOrFail($id);
      $blog->title = $request->title;
      $blog->slug = Str::slug($request->slug);
      $blog->content = $request->content;
      $blog->category_id = $request->category_id;
      $blog->status = $request->status;

      // Xử lý upload ảnh đại diện
      if ($request->hasFile('featured_image')) {
         // Xóa ảnh cũ nếu có
         if ($blog->featured_image) {
            $oldImagePath = public_path('uploads/blogs/' . $blog->featured_image);
            if (file_exists($oldImagePath)) {
               unlink($oldImagePath);
            }
         }

         $image = $request->file('featured_image');
         $file_extension = $image->extension();
         $file_name = Carbon::now()->timestamp . '_blog.' . $file_extension;
         $destinationPath = public_path('uploads/blogs');

         if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
         }

         $image->move($destinationPath, $file_name);
         $blog->featured_image = $file_name;
      }

      $blog->save();

      return redirect()->route('admin.blogs')->with('status', 'Cập nhật bài viết thành công!');
   }

   public function blogs_delete($id)
   {
      $blog = Blog::findOrFail($id);

      // Xóa ảnh đại diện nếu có
      if ($blog->featured_image) {
         $imagePath = public_path('uploads/blogs/' . $blog->featured_image);
         if (file_exists($imagePath)) {
            unlink($imagePath);
         }
      }

      $blog->delete();

      return redirect()->route('admin.blogs')->with('status', 'Xóa bài viết thành công!');
   }
}
