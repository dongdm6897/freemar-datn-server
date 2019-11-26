<?php

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Seeder;

class MasterProductStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('master_product_status')->truncate();
        $product_status_id = ProductStatusEnum::getValues();
        foreach ($product_status_id as $value) {
            DB::table('master_product_status')->insert([
                'id' =>$value,
                'name' => ProductStatusEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();

    }
}
