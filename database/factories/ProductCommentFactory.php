<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductComment::class, function (Faker $faker) {
    $product_id= $faker->randomElement(DB::table('products')->select('id')->get())->id;
    $message_id= $faker->randomElement(DB::table('message')->select('id')->get())->id;
    return [
        'product_id' => $product_id,
        'message_id' => $message_id,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
    ];
});
