<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MasterCollection::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'image' => $faker->imageUrl($width=640,$height=640),
        'search_keywords' => $faker->name.',Prof',
        'valid_from' => new DateTime('1997-09-22 09:57:18'),
        'valid_to' => new DateTime('2020-09-22 09:57:18'),
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
    ];
});
