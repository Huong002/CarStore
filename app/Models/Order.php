<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'employee_id',
        'deposit_id',       // Thêm dòng này
        'tax',
        'total',
        'status',
        'order_date',
        'total_item',
        'deposit_amount',
        'remaining_amount',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id');
    }
}
