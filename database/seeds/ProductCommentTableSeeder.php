<?php

use Illuminate\Database\Seeder;

class ProductCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('product_comment')->truncate();

        factory(App\Models\ProductComment::class, 5)->create();

        Schema::enableForeignKeyConstraints();
    }
}
