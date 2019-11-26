<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShippingAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('name');
            $table->string('phone_number');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('province');
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('district');
            $table->integer('ward_id')->unsigned();
            $table->foreign('ward_id')->references('id')->on('ward');
            $table->integer('street_id')->unsigned()->nullable();
            $table->foreign('street_id')->references('id')->on('street');
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
        Schema::dropIfExists('shipping_address');
    }
}
