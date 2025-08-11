<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
      $blog = Blog::with(['author', 'category', 'comments'])
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

      return view('blog-detail', compact('blog', 'popularBlogs', 'categories'));
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
      $request->validate([
         'author_name' => 'required|string|max:255',
         'author_email' => 'required|email|max:255',
         'content' => 'required|string'
      ]);

      $blog = Blog::findOrFail($blogId);

      BlogComment::create([
         'blog_id' => $blog->id,
         'author_name' => $request->author_name,
         'author_email' => $request->author_email,
         'content' => $request->content,
         'user_id' => Auth::check() ? Auth::user()->id : null
      ]);

      return redirect()->back()->with('success', 'Bình luận của bạn đã được thêm thành công!');
   }
}
