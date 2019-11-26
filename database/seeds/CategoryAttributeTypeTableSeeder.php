<?php

use Illuminate\Database\Seeder;

class CategoryAttributeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('category_attribute_type')->truncate();

        $category_id = DB::table('category')->inRandomOrder()->first()->id;
        $attribute_type_id = DB::table('attribute_type')->inRandomOrder()->first()->id;


        DB::table('category_attribute_type')->insert([
            'category_id' => $category_id,
            'attribute_type_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);


        Schema::enableForeignKeyConstraints();
    }
}
