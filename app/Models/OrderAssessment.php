<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAssessment extends Model
{
    protected $table = 'order_assessment';

    public function orders(){
        return $this->hasMany('App\Models\Order','order_id');
    }
    public function detailAssessmentType(){
        return $this->belongsTo('App\Models\MasterDetailAssessmentType','detail_assessment_type_id');
    }
}
