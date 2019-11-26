<?php

use Illuminate\Database\Seeder;

class MasterCollectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_collection')->truncate();

        factory(App\Models\MasterCollection::class,10)->create();

        Schema::enableForeignKeyConstraints();
    }
}
