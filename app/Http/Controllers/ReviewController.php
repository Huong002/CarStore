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

    return back()->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt.');
}

}