<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Brand::class, function (Faker $faker) {
    $brand = ['SAMSUNG','LG','HTC','HONDA','APPLE','HUAWEI','XIAOMI','D&G','GUCCI','NIKE','ADDIDAS','DURGOD','LEOPOLD','FILCO','GANA','RAPOO','LENOVO','1MORE','YAMAHA','LAVIE','SONY','ONEPLUS','REALME','OPPO','MIDEA','COKKO','DONGA'];
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(),
        'description' => $faker->name,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
    ];
});
