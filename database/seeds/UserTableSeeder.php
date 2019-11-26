<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Admin',
            'phone' => '0971267298',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'avatar' => 'https://lorempixel.com/70/70/',
            'cover_image_link' => 'https://lorempixel.com/700/700/',
            'identify_photo_id' => null,
            'balance' => 99999999999,
            'status_id' => 4,
            'sns_type' => null,
            'sns_id' => null,
            'sns_data' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        factory(App\Models\User::class,10)->create();
        Schema::enableForeignKeyConstraints();
    }
}
