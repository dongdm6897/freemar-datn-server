<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeType extends Model
{
    protected $table = "attribute_type";

    public function category(){
        return $this->belongsToMany('App\Models\User');
    }

    public function attributes(){
        return $this->hasMany('App\Models\Attribute','attribute_type_id');
    }
}
