<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('tag')->truncate();

        factory(App\Models\Tag::class,20)->create();

        Schema::enableForeignKeyConstraints();
    }
}
