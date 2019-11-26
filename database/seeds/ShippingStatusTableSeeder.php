<?php

use Illuminate\Database\Seeder;
use App\Enums\ShippingStatusEnum;

class ShippingStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('shipping_status')->truncate();
        $shipping_status_ids = ShippingStatusEnum::getValues();
        foreach ($shipping_status_ids as $value) {
            DB::table('shipping_status')->insert([
                'id' => $value,
                'name' => ShippingStatusEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
