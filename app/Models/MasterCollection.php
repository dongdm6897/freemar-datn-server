<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCollection extends Model
{
    protected $table = 'master_collection';
    protected $fillable = ['name', 'description', 'image','search_keywords','valid_from','valid_to'];
}
