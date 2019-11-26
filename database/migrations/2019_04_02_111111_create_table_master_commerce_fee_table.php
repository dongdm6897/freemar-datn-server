<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMasterCommerceFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_commerce_fee', function (Blueprint $table) {
            $table->increments('id');
            $table->double('value')->default(0.08);
            $table->integer('category_id')->nullable();
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
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
        Schema::dropIfExists('master_commerce_fee');
    }
}
