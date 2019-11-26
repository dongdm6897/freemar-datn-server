<?php

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Seeder;

class MasterOrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     */

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_order_status')->truncate();
        $order_status_id = OrderStatusEnum::getValues();
        foreach ($order_status_id as $value) {
            DB::table('master_order_status')->insert([
                'id' =>$value,
                'name' => OrderStatusEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
