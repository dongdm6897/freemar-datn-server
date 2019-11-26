<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;

class AddressController extends Controller
{
    public function getProvince()
    {
        $results = DB::table('province')->get();
        return [
            'data' => $results
        ];
    }

    public function getDistrict()
    {
        $province_id = Input::get('province_id');
        $results = DB::table('district')->where('_province_id', '=', $province_id)->get();
        return [
            'data' => $results
        ];
    }

    public function getWard()
    {
        $province_id = Input::get('province_id');
        $district_id = Input::get('district_id');
        $results = DB::table('ward')->where([
            ['_province_id', '=', $province_id],
            ['_district_id', '=', $district_id]])->get();

        return [
            'data' => $results,
        ];
    }

    public function getStreet()
    {
        $province_id = Input::get('province_id');
        $district_id = Input::get('district_id');
        $results = DB::table('street')->where([
            ['_province_id', '=', $province_id],
            ['_district_id', '=', $district_id]])->get();

        return [
            'data' => $results,
        ];
    }

}
