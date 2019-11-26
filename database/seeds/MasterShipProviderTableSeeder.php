<?php

use Illuminate\Database\Seeder;

class MasterShipProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_ship_provider')->truncate();

//        $name = ['VNPost', 'DHL', 'SuperShip', 'GHN', 'Grab', 'Giao tan noi', 'Tu den lay', 'GHTK'];
        $name = ['SuperShip', 'GHN', 'Giao tận nơi', 'Tự đến lấy'];
        $reference_price_images = [ 'http://localhost/storage/uploads/ship/ghn_reference_price.png','http://localhost/storage/uploads/ship/ghn_reference_price.png','http://localhost/storage/uploads/ship/supership_reference_price.PNG','http://localhost/storage/uploads/ship/ghn_reference_price.png','http://localhost/storage/uploads/ship/ghn_reference_price.png','http://localhost/storage/uploads/ship/ghn_reference_price.png','http://localhost/storage/uploads/ship/ghn_reference_price.png','http://localhost/storage/uploads/ship/ghn_reference_price.png'];

        foreach ($name as $key => $st) {
            DB::table('master_ship_provider')->insert([
                'name' => $st,
                'logo' => 'images',
                'company' => 'HUST',
                'address' => 'HN',
                'email' => 'ship@baibai.vn',
                'phone' => '0976543218',
                'reference_price_image' => $reference_price_images[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
