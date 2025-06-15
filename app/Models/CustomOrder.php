<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    protected $table = 'custom_orders';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'order_details',
        'delivery_address',
        'status',
    ];
}
