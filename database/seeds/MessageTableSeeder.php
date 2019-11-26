<?php

use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('message')->truncate();

        factory(App\Models\Message::class, 10)->create();

        Schema::enableForeignKeyConstraints();
    }
}
