<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'introduction' => $faker->text,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456789'),
        'avatar' => $faker->imageUrl($width=70,$height=70),
        'cover_image_link' => $faker->imageUrl($width=700,$height=700),
        'balance' => 1000000000,
        'identify_photo_id' => null,
        'status_id' => 4,
        'sns_type' => null,
        'sns_id' => null,
        'sns_data' => null,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
    ];
});
