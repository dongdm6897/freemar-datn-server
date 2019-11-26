<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $table ="shipping_address";

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select('name','phone');

    }
    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'province_id')->select('id','_name');

    }
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id')->select('id','_name','_prefix');

    }
    public function ward()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id')->select('id','_name','_prefix');

    }
    public function street()
    {
        return $this->belongsTo('App\Models\Street', 'street_id')->select('id','_name','_prefix');

    }
    public function product(){
        return $this->belongsTo('App\Models\Product', 'shipping_from_id');
    }

}
