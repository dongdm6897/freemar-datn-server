<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('buyer_id')->unsigned();
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->double('discount')->default(0);
            $table->double('sell_price')->default(0);
            $table->double('commerce_fee')->default(0);
            $table->double('payment_fee')->default(0);
            $table->double('shipping_fee')->default(0);
            $table->double('return_shipping_fee')->default(0);
            $table->integer('shipping_address_id')->unsigned();
            $table->foreign('shipping_address_id')->references('id')->on('shipping_address');
            $table->integer('shipping_status_id');
            $table->foreign('shipping_status_id')->references('id')->on('shipping_status');
            $table->integer('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('master_payment_method');
            $table->integer('status_id');
            $table->foreign('status_id')->references('id')->on('master_order_status');
            $table->string('provider_order_code')->nullable();
            $table->integer('shipping_service_id')->unsigned();
            $table->foreign('shipping_service_id')->references('id')->on('provider_service');
            $table->timestamp('shipping_done')->nullable();
            $table->timestamp('return_shipping_done')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
