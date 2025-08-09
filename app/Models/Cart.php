<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
      protected $fillable = ['user_id']; // thêm fillable để firstOrCreate hoạt động
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    // public function cartItem(){
    //     return $this->hasMany(Cart::class);
    // }

// Quan hệ đúng với bảng cart_items
    // public function items()
    // {
    //     return $this->hasMany(\App\Models\CartItem::class, 'cart_id');
    // }
    
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
//     public function cartItems()
// {
//     return $this->hasMany(CartItem::class);
// }

}