<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentifyPhoto extends Model
{
    protected $table = 'identify_photo';

    public function user(){
        return $this->hasOne('App\Models\User','identify_photo_id');
    }
}
