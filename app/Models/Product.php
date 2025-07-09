<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function cartitem(){
        return $this->belongsTo(CartItem::class);
    }


    public function images(){
            return $this->hasMany(Image::class);
        }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }
    public function review(){
        return $this->hasMany(Review::class);
    }
   
}
