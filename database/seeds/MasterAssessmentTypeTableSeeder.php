<?php

use Illuminate\Database\Seeder;

class MasterAssessmentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_assessment_type')->truncate();

        $name = ['HAPPY','JUST OK','NOT HAPPY'];
        $icons = ['smile','meh','sadTear'];
        $colors = ['008000','000000','FF0000'];

        foreach ($name as $key => $st) {
            DB::table('master_assessment_type')->insert([
                'name' => $st,
                'icon' => $icons[$key],
                'color' => $colors[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
