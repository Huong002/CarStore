<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Thêm cột deposit_id (có thể NULL)
            $table->unsignedBigInteger('deposit_id')->nullable()->after('customer_id');

            // Tạo khóa ngoại
            $table->foreign('deposit_id')
                  ->references('id')->on('deposits')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['deposit_id']);
            $table->dropColumn('deposit_id');
        });
    }
};