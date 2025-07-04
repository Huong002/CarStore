<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
}
