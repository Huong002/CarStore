<?php

namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasFactory;

class Image extends Model
{
    // use FactoriesHasFactory;

    
    protected $fillable=[
        'product_id',
        'imageName',
        'is_primary'
    ];
    
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

}