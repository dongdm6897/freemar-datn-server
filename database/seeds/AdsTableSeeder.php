<?php

use Illuminate\Database\Seeder;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ads')->truncate();

        DB::table('ads')->insert([
            'image_link' => "http://139.162.25.146/storage/uploads/product_10.jpg",
            'url' => 'https://baibai554889985.wordpress.com/',
            'title' => 'Quảng cáo website',
            'ads_type_id' => \App\Enums\AdsTypeEnum::Banner,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        Schema::enableForeignKeyConstraints();

    }
}
