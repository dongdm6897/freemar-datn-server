<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $table = "favorite_product";
    protected $primaryKey = 'user_id,product_id';
    public $incrementing = false;
}
