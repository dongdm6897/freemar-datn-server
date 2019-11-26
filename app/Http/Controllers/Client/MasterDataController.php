<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\AttributeType;
use App\Models\BankType;
use App\Models\MasterAssessmentType;
use App\Models\MasterDetailAssessmentType;
use App\Models\MasterShipProvider;
use DB;
use Illuminate\Database\QueryException;

class MasterDataController extends Controller
{
    public function getMasterData()
    {
        try {
            $commerce_fees = DB::table('master_commerce_fee')->get();
            $ship_provider = MasterShipProvider::with('shipProviderService')->get();
            $ship_time_estimation = DB::table('ship_time_estimation')->select('id', 'name')->get();
            $product_status = DB::table('master_product_status')->get();
            $order_status = DB::table('master_order_status')->get();
            $assessment_type = MasterAssessmentType::with('detailAssessmentTypes')->get();
            $payment_method = DB::table('master_payment_method')->get();
            $ship_pay_method = DB::table('ship_pay_method')->get();
            $links = DB::table('help_link')->get();
            $ship_from = DB::table('province')->get();
            $attribute_types = AttributeType::with('attributes')->get();
            $bank_type = DB::table('master_bank_type')->get();
            $bank = DB::table('master_bank')->get();
            $ads = DB::table('ads')->get();
        } catch (QueryException $exception) {
            return [
                'status' => 'fail',
                'message' => $exception
            ];
        }
        return [
            'commerce_fees' => $commerce_fees,
            'bank_type' => $bank_type,
            'ship_provider' => $ship_provider,
            'ship_time_estimation' => $ship_time_estimation,
            'product_status' => $product_status,
            'order_status' => $order_status,
            'assessment_type' => $assessment_type,
            'payment_method' => $payment_method,
            'ship_pay_method' => $ship_pay_method,
            'links' => $links,
            'bank_list' => $bank,
            'attribute_types' => $attribute_types,
            'ads_list' => $ads,
            ///TO DO create config table for user
            'app_configs' => [
                "default_grid_column_number" => 2,
                "charge_min_amount" => 50000.0,
            ],
            ///TO DO use AddressWidget
            'shipping_from' => $ship_from,
        ];
    }
}
