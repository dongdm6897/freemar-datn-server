<?php

use Illuminate\Database\Seeder;

class MasterPaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_payment_method')->truncate();

        $name = ['BAIBAI', 'VNPay'];

        $description = [
            'Sử dụng tài khoản ví baibai, miễn phí chuyển tiền & hoàn trả (khuyến khích dùng)',
            'Chuyển tiền liên ngân hàng thông qua cổng thanh toán VNPay, phí theo quy định VNPay',

        ];

        foreach ($name as $key => $st) {
            DB::table('master_payment_method')->insert([
                'name' => $st,
                'logo' => 'https://picsum.photos/75/75',
                'description' => $description[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
