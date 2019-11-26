<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductSearchTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_search_template', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('keyword')->nullable();
            $table->string('brand_ids')->nullable();
            $table->string('category_ids')->nullable();
            $table->string('size_attribute_ids')->nullable();
            $table->string('color_attribute_ids')->nullable();
            $table->double('price_from')->nullable();
            $table->double('price_to')->nullable();
            $table->string('product_status_ids')->nullable();
            $table->boolean('sold_out')->nullable();
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
        Schema::dropIfExists('product_search_template');
    }
}
