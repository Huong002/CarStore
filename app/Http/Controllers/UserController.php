<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Hiển thị giao diện thông tin người dùng
    public function show()
    {
        return view('account');
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        if (Auth::id() != $id) {
            return back()->withErrors(['unauthorized' => 'Bạn không có quyền cập nhật người dùng này.']);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Cập nhật avatar nếu có file tải lên
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'avatar_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/avatar'), $imageName);

            // Xóa ảnh cũ nếu không phải mặc định
            if ($user->image) {
            $oldImagePath = public_path('images/avatar/' . $user->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // hoặc @unlink(...) nếu muốn tránh lỗi nếu không tồn tại
            }
            }

            $user->image = $imageName;
        }

        $user->save();

     return redirect()->back()->with('account_updated', 'Cập nhật thông tin thành công!');

     
    }
}