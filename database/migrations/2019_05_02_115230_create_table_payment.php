<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount')->default(0);
            $table->double('fee')->default(0);
            $table->string('comment');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('payment_method_id')->nullable()->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('master_payment_method');
            $table->integer('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_type');
            $table->string('currency');
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
        Schema::dropIfExists('payment');
    }
}
