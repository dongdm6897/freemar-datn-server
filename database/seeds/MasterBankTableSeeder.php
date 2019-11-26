<?php

use Illuminate\Database\Seeder;

class MasterBankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_bank')->truncate();

        DB::table('master_bank')->insert([
            'code' => 'VIETCOMBANK',
            'name' => 'Ngân hàng ngoại thương (Vietcombank)',
            'logo' => 'https://sandbox.vnpayment.vn/apis/assets/images/bank/vietcombank_logo.png',
        ]);

        DB::table('master_bank')->insert([
            'code' => 'VIETINBANK',
            'name' => 'Ngân hàng công thương (Vietinbank)',
            'logo' => 'https://sandbox.vnpayment.vn/apis/assets/images/bank/vietinbank_logo.png',
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
