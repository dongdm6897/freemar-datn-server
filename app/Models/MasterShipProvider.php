<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterShipProvider extends Model
{
    protected $table = "master_ship_provider";

    public function shipProviderService(){
        return $this->hasMany('App\Models\ShipProviderService','provider_id');
    }
}
