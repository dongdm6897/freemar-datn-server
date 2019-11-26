<?php

use Illuminate\Database\Seeder;
use App\Enums\BankTypeEnum;

class MasterBankTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['LOCAL BANK','INTERNATIONAL CARD'];
        Schema::disableForeignKeyConstraints();
        DB::table('master_bank_type')->truncate();

        $bank_type_id = BankTypeEnum::getValues();
        foreach ($bank_type_id as $value) {
            DB::table('master_bank_type')->insert([
                'id' => $value,
                'code' => BankTypeEnum::getKey($value),
                'name' => $name[$value-1]
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
