<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = "attribute";

    public function product(){
        return $this->belongsToMany('App\Models\Product');
    }

    public function attributeType(){
        return $this->belongsTo('App\Models\AttributeType','attribute_type_id');
    }


}
