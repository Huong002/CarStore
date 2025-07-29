<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_item_id');
            $table->string('customer_name');
            $table->string('phone', 20);
            $table->string('address');
            $table->decimal('deposit_amount', 15, 0);
            $table->date('deposit_date');
            $table->timestamps();

            // nếu có bảng cart_items
            $table->foreign('cart_item_id')
                  ->references('id')
                  ->on('cart_items')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};