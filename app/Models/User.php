<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;
    use HasRoles;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status_id', 'balance', 'activation_token', 'sns_id', 'sns_data', 'sns_type', 'fcm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token', 'email_verified_at', 'delete_at', 'password_confirmation'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'owner_id');
    }

    public function sellingProducts()
    {
        return $this->hasMany('App\Models\Product', 'owner_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'buyer_id');
    }

    public function identifyPhoto(){
        return $this->belongsTo('App\Models\IdentifyPhoto','identify_photo_id');
    }

    public function moneyAccount(){
        return $this->belongsTo('App\Models\MoneyAccount','user_id');
    }
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'user_id');
    }
}
