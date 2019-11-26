<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    $brand_id= $faker->randomElement(DB::table('brand')->select('id')->get())->id;
    $category_id= $faker->randomElement(DB::table('category')->select('id')->get())->id;
    $user_id= $faker->randomElement(DB::table('users')->select('id')->get())->id;
    $status_id = $faker->randomElement(DB::table('master_user_status')->select('id')->get())->id;
    $target_gender_id = $faker->randomElement(DB::table('master_target_gender')->select('id')->get())->id;
    $ship_time_estimation_id = $faker->randomElement(DB::table('ship_time_estimation')->select('id')->get())->id;
    $ship_pay_method_id = $faker->randomElement(DB::table('ship_pay_method')->select('id')->get())->id;
    $number = mt_rand(1,10);
    $price = $faker->numberBetween($min = 10000, $max = 1999999);
    return [
        'name' => $faker->name,
        'image' => url()->current()."/storage/uploads/product_".$number.".jpg",
        'price' => $price,
        'commerce_fee'=>$price * 0.1,
        'original_price' => $price,
        'brand_id' => $brand_id,
        'category_id' => $category_id,
        'owner_id' => $user_id,
        'status_id' => $status_id,
        'target_gender_id' => $target_gender_id,
        'ship_provider_id' => 1,
        'weight' => 1,
        'is_public' => true,
        'represent_image_link' => null,
        'quantity' => $faker->numberBetween($min=1,$max=10000),
        'ship_time_estimation_id' => $ship_time_estimation_id,
        'shipping_from_id' => 1,
        'ship_pay_method_id' => $ship_pay_method_id
    ];
});
