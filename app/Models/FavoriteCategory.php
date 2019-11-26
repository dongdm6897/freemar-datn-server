<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteCategory extends Model
{
    protected $table = "favorite_category";
    protected $primaryKey = 'user_id, category_id';
    public $incrementing = false;
}
