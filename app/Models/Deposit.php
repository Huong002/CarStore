<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id',
        'deposit_amount',
        'customer_name',
        'phone',
        'address',
        'deposit_date',
        // 'payment_method'
];


    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }
   public function order()
{
    return $this->hasOne(\App\Models\Order::class, 'deposit_id');
}


    
}