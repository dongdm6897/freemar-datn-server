<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteBrand extends Model
{
    protected $table = "favorite_brand";
    protected $primaryKey = 'user_id,brand_id';
    public $incrementing = false;
}
