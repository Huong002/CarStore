<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customerName', // phải giống tên cột trong DB
        'email',
        'address',
        'phone',
        'gender',
        'birthDay'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
        public function orders()
{
    return $this->hasMany(Order::class, 'customer_id');
}
}