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
        'image',
        'images',
        'category_id',
        'brand_id'
    ];

    protected $dates = ['deleted_at'];
    protected static function booted()
    {
        static::addGlobalScope('notSoftDeleted', function ($builder) {
            $builder->where('isDeleted', false);
        });
    }

    public function scopeOnlySoftDeleted($query)
    {
        return $query->withoutGlobalScope('notSoftDeleted')->where('isDeleted', true);
    }

    public function scopeWithSoftDeleted($query)
    {
        return $query->withoutGlobalScope('notSoftDeleted');
    }

    public function delete()
    {
        $this->update([
            'isDeleted' => true,
            'deleted_at' => now()
        ]);

        return true;
    }

    public function restore()
    {
        $this->update([
            'isDeleted' => false,
            'deleted_at' => null
        ]);

        return true;
    }

    public function isSoftDeleted()
    {
        return $this->isDeleted === true;
    }

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
}
