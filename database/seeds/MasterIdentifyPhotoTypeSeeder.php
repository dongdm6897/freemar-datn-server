<?php

use Illuminate\Database\Seeder;
use App\Enums\IdentifyPhotoTypeEnum;

class MasterIdentifyPhotoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('identify_photo_type')->truncate();

        $name = ["ID","PASSPORT","DRIVER_LICENSE"];

        foreach ($name as $st) {
            DB::table('identify_photo_type')->insert([
                'name' => $st,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
