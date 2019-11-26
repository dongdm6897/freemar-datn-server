<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $table = "order_payment";
    protected $primaryKey = 'order_id,payment_id';
    public $incrementing = false;

}
