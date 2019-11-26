<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->integer('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category');
            $table->string('represent_image_link')->nullable();
            $table->text('reference_image_links')->nullable();
            $table->double('price')->default(0);
            $table->double('commerce_fee')->default(0);
            $table->double('weight')->default(0);
            $table->boolean('is_sold_out')->default(false);
            $table->boolean('is_public')->default(false);
            $table->double('original_price')->default(0);
            $table->double('new_product_refer_price')->default(0);
            $table->string('new_product_refer_link')->nullable();
            $table->integer('status_id');
            $table->foreign('status_id')->references('id')->on('master_product_status');
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->integer('target_gender_id')->unsigned()->nullable();
            $table->foreign('target_gender_id')->references('id')->on('master_target_gender');
            $table->integer('ship_provider_id')->unsigned()->nullable();
            $table->foreign('ship_provider_id')->references('id')->on('master_ship_provider');
            $table->integer('shipping_from_id')->nullable()->references('id')->on('shipping_address');
            $table->boolean('is_confirm_required')->default(false);
            $table->integer('ship_time_estimation_id')->unsigned()->nullable();
            $table->foreign('ship_time_estimation_id')->references('id')->on('ship_time_estimation');
            $table->integer('ship_pay_method_id')->unsigned()->nullable();
            $table->foreign('ship_pay_method_id')->references('id')->on('ship_pay_method');
            $table->boolean('is_ordering')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();

        });
        DB::statement('ALTER TABLE products ADD FULLTEXT (name)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
