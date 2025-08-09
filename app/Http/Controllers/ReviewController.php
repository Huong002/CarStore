<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'content' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'rating.required' => 'Hãy đánh giá sản phẩm',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/reviews'), $fileName);
        $imagePath = 'uploads/reviews/' . $fileName;
    }

    Review::create([
        'product_id' => $request->product_id,
        'user_id' => Auth::id(),
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'content' => $request->content,
        'rating' => $request->rating,
        'image' => $imagePath,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Đánh giá của bạn đã được gửi.');
}
public function edit($id)
{
    $review = Review::findOrFail($id);

    if (!Auth::check() || Auth::id() !== (int) $review->user_id) {
        abort(403, 'Bạn không có quyền sửa đánh giá này.');
    }

    return view('reviews.edit', compact('review'));
}

public function update(Request $request, $id)
{
    $review = Review::findOrFail($id);

    if (!Auth::check() || Auth::id() !== (int) $review->user_id) {
        abort(403, 'Bạn không có quyền cập nhật đánh giá này.');
    }

    $request->validate([
        'content' => 'nullable|string',
        'rating' => 'nullable|integer|min:1|max:5',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Nếu có ảnh mới
    if ($request->hasFile('image')) {
        if ($review->image && file_exists(public_path($review->image))) {
            unlink(public_path($review->image)); // Xóa ảnh cũ
        }
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/reviews'), $fileName);
        $review->image = 'uploads/reviews/' . $fileName;
    }

    // Giữ nguyên nếu không gửi mới
    $review->content = $request->filled('content') ? $request->content : $review->content;
    $review->rating = $request->filled('rating') ? $request->rating : $review->rating;

    $review->save();

    return redirect()->back()->with('success', 'Cập nhật đánh giá thành công.');
}


public function destroy($id)
{
    $review = Review::findOrFail($id);

    if (!Auth::check() || Auth::id() !== (int) $review->user_id) {
        abort(403, 'Bạn không có quyền xóa đánh giá này.');
    }

    if ($review->image && file_exists(public_path($review->image))) {
        unlink(public_path($review->image));
    }

    $review->delete();

    return back()->with('success', 'Xóa đánh giá thành công.');
}


}