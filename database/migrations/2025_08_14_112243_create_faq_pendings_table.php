<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_pending', function (Blueprint $table) {
            $table->id();
            $table->text('question'); // Câu hỏi từ khách hàng
            $table->timestamp('submitted_at')->useCurrent(); // Thời gian gửi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_pending');
    }
};