<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // Cho phép gán cột status và các cột cần thiết
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

   public function cart()
{
    return $this->belongsTo(\App\Models\Cart::class, 'cart_id');
}

    public function deposit()
{
    return $this->hasOne(\App\Models\Deposit::class, 'cart_item_id');
}

}