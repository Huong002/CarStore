<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use ReturnTypeWillChange;

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
    public function index()
    {
        $user = Auth::user();
        $customer = null;

        // Lấy thông tin customer nếu có
        if ($user->customer_id) {
            $customer = $user->customer;
        } else {
            // Tìm customer theo email
            $customer = Customer::where('email', $user->email)->first();
        }

        return view('account-detail', compact('user', 'customer'));
    }
    public function user_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'old_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        // Cập nhật thông tin cơ bản của user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Tìm hoặc tạo customer record cho user này
        $customer = Customer::where('email', $user->email)->first();

        if (!$customer) {
            // Tạo customer mới nếu chưa có
            $customer = new Customer();
            $customer->email = $user->email;
        }

        // Cập nhật thông tin customer
        $customer->customerName = $request->name;
        $customer->phone = $request->mobile;
        $customer->email = $request->email;
        $customer->save();

        // Liên kết customer với user nếu chưa có
        if (!$user->customer_id) {
            $user->customer_id = $customer->id;
            $user->save();
        }

        // Kiểm tra và cập nhật mật khẩu nếu có
        if ($request->filled('old_password') && $request->filled('new_password')) {
            // Kiểm tra mật khẩu cũ
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['old_password' => 'Mật khẩu cũ không đúng!'])
                    ->withInput();
            }

            // Cập nhật mật khẩu mới
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->back()->with('status', 'Cập nhật thông tin thành công!');
    }
    public function setRole(Request $request, $id){
        $users = User::findOrFail($id);
        $users -> utype = $request-> utype;
        $users->save();
        return redirect()->back()->with('success', 'Đã thay đổi quyền người dùng thành công!');
    }
}
