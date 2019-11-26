<?php

use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Seeder;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('payment_type')->truncate();
        $payment_type_id = PaymentTypeEnum::getValues();
        foreach ($payment_type_id as $value) {
            DB::table('payment_type')->insert([
                'id' =>$value,
                'name' => PaymentTypeEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
