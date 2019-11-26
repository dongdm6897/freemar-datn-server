<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchedProduct extends Model
{
    protected $table ="watched_product";
    protected $primaryKey = 'user_id,product_id';
    public $incrementing = false;
}
