<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('brand')->truncate();
        $brand = ['SAMSUNG','LG','HTC','HONDA','APPLE','HUAWEI','XIAOMI','D&G','GUCCI','NIKE','ADDIDAS','DURGOD','LEOPOLD','FILCO','GANA','RAPOO','LENOVO','1MORE','YAMAHA','LAVIE','SONY','ONEPLUS','REALME','OPPO','MIDEA','COKKO','DONGA'];
        foreach ($brand as $key => $value)
        {
            \Illuminate\Support\Facades\DB::table('brand')->insert([
                'name' => $value,
                'image' => 'http://lorempixel.com/200/200/',
                'description' => "Let me down slowly",

            ]);
        }

//        factory(App\Models\Brand::class, 100)->create();
        Schema::enableForeignKeyConstraints();
    }
}
