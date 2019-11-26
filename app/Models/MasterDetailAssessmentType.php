<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDetailAssessmentType extends Model
{
    protected $table = 'master_detail_assessment_type';

    public function assessmentType()
    {
        return $this->belongsTo('App\Models\MasterAssessmentType', 'assessment_type_id');
    }

    public function orderAssessment()
    {
        return $this->hasMany('App\Models\OrderAssessment', 'detail_assessment_type_id');
    }
}
