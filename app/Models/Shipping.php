<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shipping'; // Specify the table name (optional if following convention)

    protected $fillable = [
        'order_id', 'status', 'carrier', 'tracking_number', 'address', 'shipping_cost'
    ];

    // Define relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
