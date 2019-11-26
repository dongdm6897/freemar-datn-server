<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recipient_id')->unsigned()->nullable();
            $table->foreign('recipient_id')->references('id')->on('users');
            $table->integer('type_id');
            $table->foreign('type_id')->references('id')->on('master_notification_type');
            $table->string('title');
            $table->string('body');
            $table->string('image')->default('https://via.placeholder.com/75x75?text=Visit+baibai.com+Now');
            $table->integer('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->boolean('is_unread')->default(false);
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
        Schema::dropIfExists('notification');
    }
}
