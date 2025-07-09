<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
