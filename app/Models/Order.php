<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';

    protected $fillable = [
        'order_number', 'user_id', 'status', 'grand_total', 'item_count', 'payment_status', 'payment_method',
        'first_name', 'last_name', 'address', 'city', 'country', 'post_code', 'phone_number', 'notes'
    ];

}
