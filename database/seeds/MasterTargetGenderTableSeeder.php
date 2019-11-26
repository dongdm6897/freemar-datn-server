<?php

use Illuminate\Database\Seeder;

class MasterTargetGenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_target_gender')->truncate();

        $value = ['Male', 'Female', 'JLBT'];

        foreach ($value as $val) {
            DB::table('master_target_gender')->insert([
                'value' => $val,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();

    }
}
