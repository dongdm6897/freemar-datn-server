<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {

    return [
        'discount' =>$faker->numberBetween(0,100),
        'sell_price' => $faker->numberBetween(100000,100000),
        'sell_datetime'=>$faker->dateTime,
        'shipping_datetime'=>$faker->dateTime,
    ];
});
