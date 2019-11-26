<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = "follow";
    protected $primaryKey = 'user_id, followed_user_id';
}
