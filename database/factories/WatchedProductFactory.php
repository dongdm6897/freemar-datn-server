<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WatchedProduct::class, function (Faker $faker) {
    $user_id= $faker->randomElement(DB::table('users')->select('id')->get())->id;
    $product_id= $faker->randomElement(DB::table('products')->select('id')->get())->id;
    return [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
    ];
});
