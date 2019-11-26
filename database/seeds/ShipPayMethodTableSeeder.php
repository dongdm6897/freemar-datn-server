<?php

use Illuminate\Database\Seeder;

class ShipPayMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ship_pay_method')->truncate();

        $name = ['pay_when_order', 'pay_when_received', 'free_ship'];

        $description = [
            'Trả tiền ship khi đặt hàng',
            'Trả tiền ship khi nhận hàng',
            'Free ship'

        ];

        foreach ($name as $key => $val) {
            DB::table('ship_pay_method')->insert([
                'name' => $val,
                'description' => $description[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
