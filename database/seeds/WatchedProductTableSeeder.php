<?php

use Illuminate\Database\Seeder;

class WatchedProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('watched_product')->truncate();

        factory(App\Models\WatchedProduct::class, 2)->create();
        Schema::enableForeignKeyConstraints();
    }
}
