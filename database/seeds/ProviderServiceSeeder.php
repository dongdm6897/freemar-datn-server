<?php

use Illuminate\Database\Seeder;

class ProviderServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('provider_service')->truncate();
        $supership_description = ['Tốc hành', 'Tiết kiệm'];
        $ghn_description = ['Giao 6 giờ','Giao 1 ngày','Giao 2 ngày','Giao 3 ngày','Giao 4 ngày','Giao 5 ngày','Giao 6 ngày'];
        $supership_code_keys = \App\Enums\SuperShipServiceEnum::getKeys();
        $supership_code_values = \App\Enums\SuperShipServiceEnum::getValues();
        $supership_code_length = sizeof($supership_code_keys);
        for ($i = 0; $i < $supership_code_length; $i++) {
            DB::table('provider_service')->insert([
                'provider_id' => 1,
                'service_code' => (int)$supership_code_values[$i],
                'service_name' => $supership_code_keys[$i],
                'description' => $supership_description[$i],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        $ghn_code_keys = \App\Enums\GHNServiceEnum::getKeys();
        $ghn_code_values = \App\Enums\GHNServiceEnum::getValues();
        $ghn_code_length = sizeof($ghn_code_keys);
        for ($i = 0; $i < $ghn_code_length; $i++) {
            DB::table('provider_service')->insert([
                'provider_id' => 2,
                'service_code' => (int)$ghn_code_values[$i],
                'service_name' => $ghn_code_keys[$i],
                'description' => $ghn_description[$i],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
