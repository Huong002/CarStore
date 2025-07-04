<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function user(){
        return $this->hasMany(User::class);
    }
    public function order(){
        return $this-> hasMany(Order::class);
    }
}
