<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAssessmentType extends Model
{
    protected $table = 'master_assessment_type';

    public function detailAssessmentTypes(){
        return $this->hasMany('App\Models\MasterDetailAssessmentType','assessment_type_id');
    }

}
