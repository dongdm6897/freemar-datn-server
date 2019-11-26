<?php

use Illuminate\Database\Seeder;

class AttributeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('attribute_type')->truncate();

        $data_type = ['COLOR', 'SIZE_CLOTHES', 'SIZE_SHOES', 'SPEED_CPU', 'SIZE_HDD'];
        $titles = ['Color','Size (Clothes)','Size (shoes)','Speed (cpu)', 'Speed (Hard disk)'];
        $groups = ['color','size','size','speed','speed'];

        foreach ($data_type as $key => $st) {
            DB::table('attribute_type')->insert([
                'data_type' => $st,
                'title' => $titles[$key],
                'icon_name' => $st,
                'group' => $groups[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
