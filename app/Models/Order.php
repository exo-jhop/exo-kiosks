<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'order_number',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'status' => 'string',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
