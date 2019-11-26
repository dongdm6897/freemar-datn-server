<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Message::class, function (Faker $faker) {
    $user_id= $faker->randomElement(DB::table('users')->select('id')->get())->id;
    return [
        'content' => $faker->text,
        'sender_id' => $user_id,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
    ];
});
