<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
   
        'category_id',
        'brand_id'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function cartitem()
    {
        return $this->belongsTo(CartItem::class);
    }


    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
