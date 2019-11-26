<?php

use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('attribute')->truncate();

        //Color
        $name = ['Red','Black','Lime','Blue','Yellow','Cyan','Magenta','White','Gray','Purple','Green','Navy'];
        $value = ['FF0000', '000000', '00FF00', '0000FF','FFFF00','00FFFF','FF00FF','FFFFFF','808080','800080','008000','000080'];
        foreach ($name as $key => $st) {
            DB::table('attribute')->insert([
                'attribute_type_id' => 1,
                'name' => $name[$key],
                'value' => $value[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        //Size Clothes
        $name = ['XL','XS','L','S','M'];
        $value = ['XL','XS','L','S','M'];
        foreach ($name as $key => $st) {
            DB::table('attribute')->insert([
                'attribute_type_id' => 2,
                'name' => $name[$key],
                'value' => $value[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
