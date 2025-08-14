<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqPending extends Model
{
    protected $table = 'faq_pending'; // Tên bảng
    public $timestamps = false; // Không dùng created_at, updated_at mặc định

    protected $fillable = [
        'question',
        'submitted_at'
    ];
}