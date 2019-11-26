<?php

use Illuminate\Database\Seeder;

class ShipTimeEstimationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ship_time_estimation')->truncate();

        $name = ['1-2 days', '2-3 days', '3-4 days', '4-5 days', '5-6 days'];

        foreach ($name as $val) {
            DB::table('ship_time_estimation')->insert([
                'name' => $val,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
