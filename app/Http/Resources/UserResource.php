<?php

namespace App\Http\Resources;

use App\Models\ShippingAddress;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $favorite_brand = DB::table('favorite_brand')
            ->join('brand', 'id', '=', 'brand_id')
            ->select('brand.id', 'brand.name', 'brand.description', 'brand.image')
            ->where('user_id', '=', $this->id)
            ->get();

        $favorite_category = DB::select('SELECT id,name,icon,(SELECT name FROM category WHERE id = category_children.parent_id) AS parent_name
                                      FROM category AS category_children
                                      WHERE id IN (SELECT category_id FROM favorite_category WHERE user_id = ?)', [$this->id]);

        $favorite_category = collect($favorite_category)->map(function ($data) {
            if ($data->parent_name != null)
                $name = $data->parent_name . ' > ' . $data->name;
            else
                $name = $data->name;
            $results = [
                "id" => $data->id,
                "name" => $name,
            ];
            return $results;
        });

        $favorite_product = DB::table('favorite_product')
            ->select('product_id')
            ->where('user_id', '=', $this->id)
            ->get();

        $favorite_product_ids = collect($favorite_product)->map(function ($data) {
            return $data->product_id;
        });

        $shipping_address = DB::table('shipping_address')
            ->join('province', 'province.id', '=', 'shipping_address.province_id')
            ->join('district', 'district.id', '=', 'shipping_address.district_id')
            ->leftJoin('ward', 'ward.id', '=', 'shipping_address.ward_id')
            ->leftJoin('street', 'street.id', '=', 'shipping_address.street_id')
            ->select('shipping_address.id as id', 'name', 'phone_number', 'address',
                'province.id as province_id', 'province._name as province_name',
                'district.id as district_id', 'district._name as district_name', 'district._prefix as district_prefix','district._ghn_code as district_ghn_code',
                'ward.id as ward_id', 'ward._name as ward_name', 'ward._prefix as ward_prefix',
                'street.id as street_id', 'street._name as street_name', 'street._prefix as street_prefix')
            ->where('user_id', '=', $this->id)
            ->get();
        $default_shipping_address = null;
        $shipping_address = collect($shipping_address)->map(function ($data) {
            $results = [
                "id" => $data->id,
                "name" => $data->name,
                "phone_number" => $data->phone_number,
                "address" => $data->address,
                "province" => [
                    "id" => $data->province_id,
                    "_name" => $data->province_name
                ],
                "district" => [
                    "id" => $data->district_id,
                    "_name" => $data->district_name,
                    "_prefix" => $data->district_prefix,
                    "_ghn_code" => $data->district_ghn_code
                ],
                "ward" => [
                    "id" => $data->ward_id,
                    "_name" => $data->ward_name,
                    "_prefix" => $data->ward_prefix
                ],
                "street" => [
                    "id" => $data->street_id,
                    "_name" => $data->street_name,
                    "_prefix" => $data->street_prefix
                ]

            ];
            if ($data->id == $this->default_shipping_address) {
                $default_shipping_address = $results;
            }
            return $results;
        });

        $followed_user_ids = DB::select('SELECT followed_user_id FROM follow WHERE user_id= ?', [$this->id]);
        $followed_user_ids = collect($followed_user_ids)->map(function ($data) {
            return $data->followed_user_id;
        })->toArray();

        $money_accounts = DB::select('SELECT * FROM money_account WHERE user_id = ?', [$this->id]);

        $search_history = DB::select('SELECT content FROM search_history WHERE user_id = ?', [$this->id]);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'password' => $this->password,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'introduction' => $this->introduction,
            'cover_image_link' => $this->cover_image_link,
            'balance' => $this->balance,
            'identify_photo' => $this->identifyPhoto,
            'status_id' => $this->status_id,
            'sns_id' => $this->sns_id,
            'sns_data' => json_decode($this->sns_data),
            'sns_type' => $this->sns_type,
            'followed_user_ids' => $followed_user_ids,
            'favorite_brands' => $favorite_brand,
            'favorite_product_ids' => $favorite_product_ids,
            'favorite_categories' => $favorite_category,
            'shipping_addresses' => $shipping_address,
            'default_shipping_address' => $default_shipping_address,
            'default_shipping_provider' => $this->default_shipping_provider,
            'money_accounts' => $money_accounts,
            'search_history' => $search_history,
            'point_happy' => $this->point_happy,
            'point_just_ok' => $this->point_just_ok,
            'point_not_happy' => $this->point_not_happy,
            'notify_product_comment' => (bool)$this->notify_product_comment,
            'notify_order_chat' => (bool)$this->notify_order_chat,
        ];
    }
}
