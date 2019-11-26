<?php

use Illuminate\Database\Seeder;

class AdsTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ads_type')->truncate();
        $ads_type = \App\Enums\AdsTypeEnum::getValues();
        foreach ($ads_type as $value) {
            DB::table('ads_type')->insert([
                'id' => $value,
                'name' => \App\Enums\AdsTypeEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
