<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDetailAssessmentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_detail_assessment_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assessment_type_id')->unsigned();
            $table->foreign('assessment_type_id')->references('id')->on('master_assessment_type');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_detail_assessment_type');
    }
}
