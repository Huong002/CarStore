<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    } 
    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }
}
