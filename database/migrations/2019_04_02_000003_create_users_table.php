<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->unique()->nullable();
            $table->string('name')->nullable();
            $table->text('introduction')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_image_link')->nullable();
            $table->integer('identify_photo_id')->unsigned()->nullable();
            $table->foreign('identify_photo_id')->references('id')->on('identify_photo')->onDelete('set null');
            $table->integer('status_id');
            $table->foreign('status_id')->references('id')->on('master_user_status');
            $table->string('sns_id')->nullable();
            $table->string('sns_type')->nullable();
            $table->mediumText('sns_data')->nullable();
            $table->string('activation_token')->nullable();
            $table->string('fcm_token')->nullable();
            $table->double('balance')->default(0.0);
            $table->integer('point_happy')->default(0);
            $table->integer('point_just_ok')->default(0);
            $table->integer('point_not_happy')->default(0);
            $table->boolean('notify_product_comment')->default(false);
            $table->boolean('notify_order_chat')->default(false);
            $table->integer('default_shipping_address')->default(0);
            $table->integer('default_shipping_provider')->unsigned()->nullable();
            $table->foreign('default_shipping_provider')->references('id')->on('master_ship_provider')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
