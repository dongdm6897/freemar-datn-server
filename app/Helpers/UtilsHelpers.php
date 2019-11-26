<?php
use Illuminate\Http\Request;

if (!function_exists('chaneKeyArray')) {
    function chaneKeyArray($array, $old_key, $new_key)
    {

        if (!array_key_exists($old_key, $array))
            return $array;

        $keys = array_keys($array);
        $keys[array_search($old_key, $keys)] = $new_key;

        return array_combine($keys, $array);
    }
}
if (!function_exists('responseShippingAddress')) {
    function responseShippingAddress($condition)
    {
        $data = DB::table('shipping_address')
            ->join('province', 'province.id', '=', 'shipping_address.province_id')
            ->join('district', 'district.id', '=', 'shipping_address.district_id')
            ->leftJoin('ward', 'ward.id', '=', 'shipping_address.ward_id')
            ->leftJoin('street', 'street.id', '=', 'shipping_address.street_id')
            ->select('shipping_address.id as id', 'name', 'phone_number', 'address',
                'province.id as province_id', 'province._name as province_name',
                'district.id as district_id', 'district._name as district_name', 'district._prefix as district_prefix', 'district._ghn_code as district_ghn_code',
                'ward.id as ward_id', 'ward._name as ward_name', 'ward._prefix as ward_prefix','ward._ghn_code as ward_ghn_code',
                'street.id as street_id', 'street._name as street_name', 'street._prefix as street_prefix')
            ->where('shipping_address.id', '=', $condition)
            ->first();
        $shipping_address = null;
        if($data != null)
            $shipping_address = [
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
                    "_prefix" => $data->ward_prefix,
                    "_ghn_code" => $data->ward_ghn_code
                ],
                "street" => [
                    "id" => $data->street_id,
                    "_name" => $data->street_name,
                    "_prefix" => $data->street_prefix
                ]

            ];
        return $shipping_address;
    }
}