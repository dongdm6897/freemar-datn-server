<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    public $fillable = ['product_id', 'buyer_id', 'discount', 'sell_price', 'sell_datetime', 'shipping_datetime', 'shipping_address_id', 'payment_method_id', 'order_status_id'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function buyer()
    {
        return $this->belongsTo('App\Models\User', 'buyer_id');
    }

    public function status(){
        return $this->belongsTo('App\Models\OrderStatus','status_id');
    }

    public function orderAssessment(){
        return $this->belongsTo('App\Models\OrderAssessment','order_id');
    }

    public function payment(){
        return $this->hasManyThrough('App\Models\Payment','App\Models\OrderPayment','order_id','payment_id','id');
    }

}
