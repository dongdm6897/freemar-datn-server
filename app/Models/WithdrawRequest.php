<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $table = "withdraw_request";

    public function moneyAccount(){
        return $this->hasMany('App\Models\MoneyAccount', 'id');
    }
}
