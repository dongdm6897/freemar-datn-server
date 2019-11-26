<?php

namespace App\Http\Controllers\Client;

use App\Enums\NotificationTypeEnum;
use App\Enums\ShippingStatusEnum;
use App\Enums\ShipProviderEnum;
use App\Enums\SuperShipEnum;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Jobs\SaveProviderOrderCode;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\Province;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\Ward;
use App\Notifications\FreeMarNotification;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Nexmo\Response;
use function React\Promise\map;

class ShipController extends ObjectController
{
    public $status_pending = array(SuperShipEnum::CHO_DUYET, SuperShipEnum::CHO_LAY_HANG);
    public $status_pick_up = array(SuperShipEnum::DANG_LAY_HANG);
    public $status_picked_up = array(SuperShipEnum::DA_LAY_HANG, SuperShipEnum::DA_NHAP_KHO, SuperShipEnum::DANG_CHUYEN_KHO_GIAO, SuperShipEnum::DA_CHUYEN_KHO_GIAO);
    public $status_pickup_failed = array(SuperShipEnum::HOAN_LAY_HANG, SuperShipEnum::KHONG_LAY_DUOC);
    public $status_delivering = array(SuperShipEnum::DANG_GIAO_HANG);
    public $status_delivered = array(SuperShipEnum::DA_GIAO_HANG_TOAN_BO,SuperShipEnum::DA_GIAO_HANG_MOT_PHAN);
    public $status_deliver_failed = array( SuperShipEnum::KHONG_GIAO_DUOC, SuperShipEnum::HOAN_GIAO_HANG);


    public function getShipProviders()
    {
        return DB::table('master_ship_provider')->get();
    }


    public function getData(Request $request, $id)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.mysupership.vn']);
        $response = $client->request('GET', '/v1/partner/orders/info?code=' . $id, [
            'form_params' => [
                // 'name' => 'krunal',
            ]
        ]);
        $response = $response->getBody()->getContents();
        return $response;
    }


    public function getOrderStatus(Request $request)
    {

        $order_response = convertRequestBodyToArray($request);
        if ($order_response != null) {
            $order_code = $order_response['code'];
            $supership_order_status = $order_response['status'];
            $shipping_status = ShippingStatusEnum::PENDING;

            if (in_array($supership_order_status, $this->status_pending))
                $shipping_status = ShippingStatusEnum::PENDING;

            elseif (in_array($supership_order_status, $this->status_pick_up))
                $shipping_status = ShippingStatusEnum::PICK_UP;

            elseif (in_array($supership_order_status, $this->status_picked_up))
                $shipping_status = ShippingStatusEnum::PICKED_UP;

            elseif (in_array($supership_order_status, $this->status_pickup_failed))
                $shipping_status = ShippingStatusEnum::PICKUP_FAILED;

            elseif (in_array($supership_order_status, $this->status_delivering))
                $shipping_status = ShippingStatusEnum::DELIVERING;

            elseif (in_array($supership_order_status, $this->status_delivered))
                $shipping_status = ShippingStatusEnum::DELIVERED;

            elseif (in_array($supership_order_status, $this->status_deliver_failed))
                $shipping_status = ShippingStatusEnum::DELIVER_FAILED;

//            $this->table = 'orders';
//            $this->update_key = 'provider_order_code';
//            $this->values = ['provider_order_code' => $order_code, 'shipping_status_id' => $shipping_status];
//            $response = $this->update();
             SaveProviderOrderCode::dispatch($order_code,$shipping_status);

            //send notification to buyer and seller
            $query1 = DB::table('orders')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select('orders.buyer_id', 'products.owner_id')
                ->where('provider_order_code', '=', $order_code)
                ->first();

            $array_user = [$query1->owner_id, $query1->buyer_id];

            $notification = new FreeMarNotification();
            $notification->body = 'Đơn hàng của bạn #' . $order_code;
            $notification->title = "Tình trạng đơn hàng";
            $type = NotificationTypeEnum::ORDER;
            $data_type = [
                "shipping_status_id" => $shipping_status,
                "order_status_id" => 1
            ];
            $notification->sendNotification($array_user, $type, json_encode($data_type));

            return responseSuccess('success');
        }


        return responseFail('order response null');

    }

    public function getOrderInfo(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        if (!$order->provider_order_code) $this->returnError('401', 'San phẩm chưa được gửi lên Supership', 200);
        $provider_order_code = $order->provider_order_code;
        $client = new Client(['base_uri' => 'https://api.mysupership.vn']);

        $header1 = $request->header('Accept');
        $header2 = $request->header('Authorization');
        $header3 = $request->header('Content-Type');
        $response = $client->request('GET', '/v1/partner/orders/info',
            [
                'headers' => [
                    'Accept' => $header1,
                    'Authorization' => $header2,
                    'Content-Type' => $header3
                ],
                'body' => json_encode([
                    'code' => $provider_order_code,
                ])
            ]
        );
        $response = $response->getBody()->getContents();
        return $response;
    }

    public function createWarehouses(Request $request)
    {
        $client = new Client(['base_uri' => 'https://api.mysupership.vn']);
        $body = $request->getContent();
        $header = collect($request->header())->transform(function ($item) {
            return $item[0];
        });
        $header1 = $request->header('Accept');
        $header2 = $request->header('Authorization');
        $header3 = $request->header('Content-Type');
        $response = $client->request('POST', '/v1/partner/warehouses/create',
            [
                'headers' => [
                    'Accept' => $header1,
                    'Authorization' => $header2,
                    'Content-Type' => $header3
                ],
                'body' => $body
            ]
        );
        $response = $response->getBody()->getContents();
        return $response;

    }

    public function createWebHook(Request $request)
    {
        $client = new Client(['base_uri' => 'https://api.mysupership.vn']);
        $body = $request->getContent();

        $header1 = $request->header('Accept');
        $header2 = $request->header('Authorization');
        $header3 = $request->header('Content-Type');
        $response = $client->request('POST', 'v1/partner/webhooks/create',
            [
                'headers' => [
                    'Accept' => $header1,
                    'Authorization' => $header2,
                    'Content-Type' => $header3
                ],
                'body' => $body
            ]
        );
        $response = $response->getBody()->getContents();
        return $response;
    }

    public function getShippingServiceByProviderId($provider_id)
    {
        $query = DB::table('provider_service')
            ->select('service_code', 'service_name', 'description')
            ->where('provider_id', '=', $provider_id)
            ->get();
        return $query;
    }


    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }


    //GHN


}
