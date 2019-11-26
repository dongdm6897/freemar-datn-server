<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->timestamps();

       /*     "code": "S634172SGNT.0000001",
    "soc": "JLN-1805-1456",
    "phone": "01629091355",
    "address": "47 Huỳnh Văn Bánh",
    "weight": 200,
    "fshipment": 20000,
    "status": "11",
    "status_name": "Đã Giao Hàng Toàn Bộ",
    "updated_at": "2018-06-10T08:00:00+07:00"*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhooks');
    }
}
