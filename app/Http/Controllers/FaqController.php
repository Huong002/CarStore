<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index()
    {
        // Lấy tất cả FAQ và nhóm theo category
        $faqs = Faq::orderBy('created_at', 'desc')->get()->groupBy('category');

        // Trả về view faq.blade.php
        return view('faq', compact('faqs'));
    }
    public function storePending(Request $request)
{
    $request->validate([
        'question' => 'required|string|max:1000',
    ]);

    DB::table('faq_pending')->insert([
        'question' => $request->question,
        'submitted_at' => now(),
    ]);

   return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi câu hỏi! Chúng tôi sẽ phản hồi sớm nhất.');

}
}