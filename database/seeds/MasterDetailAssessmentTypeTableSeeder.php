<?php

use Illuminate\Database\Seeder;

class MasterDetailAssessmentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_detail_assessment_type')->truncate();

        $name = ['HAPPY','JUST OK','NOT HAPPY'];

        $happys = ['Good package','Fair price','Default'];
        foreach ($happys as $key => $st) {
            DB::table('master_detail_assessment_type')->insert([
                'name' => $happys[$key],
                'assessment_type_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        $just_oks = ['Bad package','Doesn\'t look like picture','Higher price','Confirmed slow','Wrong item','Default'];
        foreach ($just_oks as $key => $st) {
            DB::table('master_detail_assessment_type')->insert([
                'name' => $just_oks[$key],
                'assessment_type_id' => 2,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        $not_happys = ['Bad package','Doesn\'t look like picture','Higher price','Confirmed slow','Wrong item','Default'];
        foreach ($not_happys as $key => $st) {
            DB::table('master_detail_assessment_type')->insert([
                'name' => $not_happys[$key],
                'assessment_type_id'=>3,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
