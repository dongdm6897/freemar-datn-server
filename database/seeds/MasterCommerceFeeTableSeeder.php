<?php

use Illuminate\Database\Seeder;

class MasterCommerceFeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_commerce_fee')->truncate();

        $value = [0.08, 0.1];
        $valid_from = ['2018-01-01 00:00:00.000', '2018-12-31 00:00:00.000'];
        $valid_to = ['2019-01-01 00:00:00.000', '9999-01-01 00:00:00.000'];

        foreach ($value as $key => $st) {
            DB::table('master_commerce_fee')->insert([
                'value' => $st,
                'valid_from' => $valid_from[$key],
                'valid_to' => $valid_to[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
