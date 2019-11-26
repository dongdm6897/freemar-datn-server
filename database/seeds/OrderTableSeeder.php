<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Order::class,10000)->create(
            [
                'product_id' => $this->getRandomProductId(),
                'buyer_id' => $this -> getRandomOwnerId(),
                'discount' => 0.01,
                'sell_price' => 500,
                'sell_datetime' => date("Y-m-d H:i:s"),
                'shipping_datetime' => date("Y-m-d H:i:s"),
                'shipping_address_id' => $this -> getRandomShippingAddressId(),
                'payment_method_id' =>$this->getRandomPaymentMethodId(),
                'order_status_id' => $this->getRandomOrderStatusId(),
            ]
        );
    }

    public function getRandomProductId(){
        $product = App\Models\Product::inRandomOrder()->first();
        return $product->id;
    }
    public function getRandomShippingAddressId(){
        $address = \Illuminate\Support\Facades\DB::table('shipping_address')->inRandomOrder()->first();
        return $address->id;
    }
    public function getRandomOwnerId(){
        $owner = \App\Models\User::inRandomOrder()->first();
        return $owner->id;
    }
    public function getRandomShippingMethodId(){
        $ship_method =\Illuminate\Support\Facades\DB::table('master_ship_provider')->inRandomOrder()->first();
        return $ship_method->id;
    }

    public function getRandomPaymentMethodId(){
        $ship_method =\Illuminate\Support\Facades\DB::table('master_payment_method')->inRandomOrder()->first();
        return $ship_method->id;
    }

    public function getRandomOrderStatusId(){
        $ship_method =\Illuminate\Support\Facades\DB::table('master_order_status')->inRandomOrder()->first();
        return $ship_method->id;
    }


}
