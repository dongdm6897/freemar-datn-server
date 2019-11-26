<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyAccount extends Model
{
    protected $table = "money_account";

    public function user(){
        return $this->hasMany('App\Models\User', 'user_id');
    }
    public function withdrawRequest(){
        return $this->belongsTo('App\Models\WithdrawRequest','money_account_id');
    }
}
