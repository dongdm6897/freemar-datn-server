<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $table = "product_comment";
    protected $primaryKey = 'product_id,message_id';
    public $incrementing = false;
}
