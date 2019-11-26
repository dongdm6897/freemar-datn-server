<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureResetShipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            '
         CREATE PROCEDURE `resetReturnShipping`(
            IN orderTransactionFinished INT,
            IN orderShipDone INT,
            IN orderAssessment INT
         )
            BEGIN
               SET @ids := 0;
                    UPDATE orders
                    SET status_id = orderTransactionFinished
                    WHERE shipping_done <= ADDDATE(NOW(), INTERVAL -3 DAY) 
                        AND status_id >= orderShipDone AND status_id <= orderAssessment
                        AND ( SELECT @ids := CONCAT_WS(\',\', id, @ids) );
               UPDATE 
                    users T1 join products T2 on T1.id = T2.owner_id
               SET 
                    T1.balance = T1.balance + T2.price - T2.commerce_fee
               WHERE FIND_IN_SET(T2.id,@ids);
               SELECT @ids;
            END'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS resetReturnShipping');
    }
}
