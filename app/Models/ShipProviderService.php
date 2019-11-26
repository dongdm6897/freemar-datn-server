<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipProviderService extends Model
{
    protected $table = "provider_service";

    public function shipProvider(){
        $this->belongsTo('App\Models\MasterShipProvider','provider_id');
    }
}
