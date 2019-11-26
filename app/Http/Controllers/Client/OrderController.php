<?php

namespace App\Http\Controllers\Client;

use App\Enums\AssessmentType;
use App\Enums\NotificationTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\ShipProviderEnum;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Notifications\FreeMarNotification;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class OrderController extends ObjectController
{
    protected $table = 'orders';

    public function setOrder(Request $request)
    {
        $id = $request->input('id');
        $this->values = convertRequestBodyToArray($request);
        $product_id = $this->values['product_id'];
        $buyer_name = Auth::user()->name;
//        $seller_id = DB::table('products')->where('id', '=', $product_id)->get(['owner_id'])[0]->owner_id;
        $product = DB::table('products')->select('owner_id', 'name')->where('id', '=', $product_id)->first();

        $notification = new FreeMarNotification();

        if ($id != null) {
            $res = $this->update();
            $notification->body = "Update an Order";
            $notification->title = "Order";
        } else {
            $order_id = $this->createGetId();
            if ($order_id) {
                $res = [
                    "status" => "success",
                    "order_id" => $order_id
                ];
                $notification->body = "Update an Order";
                $notification->title = "Order";
                DB::table('products')->where('id', '=', $product_id)->update([
                    'is_ordering' => true,
//                    'is_sold_out' => true
                ]);
            } else {
                $res = [
                    "status" => "Fail",
                    "order_id" => null
                ];
            }
        }
        if ($res['status'] == "success") {
            /// send notification
            $type = NotificationTypeEnum::ORDER;
            $notification->title = "Order";
            $notification->body = "[Đặt hàng] $buyer_name đã mua sản phẩm  $product->name";
            $data_type = [
                "order_id" => $order_id
            ];
            $notification->sendNotification([$product->owner_id], $type, json_encode($data_type));
        }
        return $res;
    }

    public function setOrderAssessment(Request $request)
    {
        $this->values = convertRequestBodyToArray($request);
        $order_status = $this->values['order_status'];
        $order_id = $this->values['order_id'];
        $user_id = $this->values['notification_user_id'];//Who's send notification
        $assessment_type_id = $this->values['assessment_type_id'];
        $return_shipping_fee = $this->values['return_shipping_fee'];
        unset($this->values['order_status'], $this->values['notification_user_id'],
            $this->values['assessment_type_id'], $this->values['return_shipping_fee']);
        switch ($assessment_type_id) {
            case AssessmentType::HAPPY:
                DB::table('users')->where('id', '=', $user_id)->increment('point_happy');
                break;
            case AssessmentType::JUST_OK:
                DB::table('users')->where('id', '=', $user_id)->increment('point_just_ok');
                break;
            case AssessmentType::NOT_HAPPY:
                DB::table('users')->where('id', '=', $user_id)->increment('point_not_happy');
                break;
            default:
                break;
        }
        $this->table = 'order_assessment';
        $res = $this->createGetId();
        if ($res) {
            $this->updateOrderStatus(
                ['id' => $order_id, 'status_id' => $order_status, 'return_shipping_fee' => $return_shipping_fee], $user_id);
            return [
                'status' => 'success',
                'id' => $res
            ];
        }
        return responseFail('Fail');

    }

    public function setOrderStatus(Request $request)
    {
        $this->values = convertRequestBodyToArray($request);

        $user_id = $this->values['notification_user_id'];//Who's send notification
        unset($this->values['notification_user_id']);
        $res = $this->updateOrderStatus($this->values, $user_id);
        return $res;
    }

    public function updateOrderStatus($values, $user_id)
    {
        $this->table = "orders";
        $this->values = $values;
        $res = $this->update();
        $notification = new FreeMarNotification();
        $notification->title = "Order";

        switch ($this->values['status_id']) {
            case OrderStatusEnum::ORDER_PAID:
                $notification->body = "[Đã thanh toán] Người mua đã thanh toán tiền cho chúng tôi";
                break;
            case OrderStatusEnum::ORDER_APPROVED:
                $notification->body = "[Đồng ý] Người bán đã đồng ý bán hàng cho bạn";
                break;
            case OrderStatusEnum::ORDER_REJECTED:
                $notification->body = "[Từ chối] Người bán đã không đồng ý bán hàng cho bạn";
                break;
            case OrderStatusEnum::RETURN_REQUESTED:
                $notification->body = "[Yêu cầu trả hàng] Người mua yêu cầu trả hàng";
                break;
            case OrderStatusEnum::RETURN_CONFIRM:
                $notification->body = "[Xác nhận trả hàng] Người bán đã đồng ý trả hàng";
                if ($this->values['return_shipping_fee'] > 0) {
                    try{
                        DB::select('UPDATE users SET balance = balance - ? 
                                      WHERE id = ?', [$this->values['return_shipping_fee'], $user_id]);
                    }catch (QueryException $exception){
                        return $exception;
                    }
                }
                break;
            case OrderStatusEnum::TRANSACTION_FINISHED:
                $notification->body = "[Mua bán thành công]";
                try{
                    DB::select('UPDATE 
                                          orders join products on orders.product_id = products.id 
                                                 join users on users.id = products.owner_id
                                      SET 
                                          orders.status_id = ?,
                                          users.balance = users.balance + products.price - products.commerce_fee,
                                          products.is_sold_out = true 
                                      WHERE orders.id = ?',[OrderStatusEnum::TRANSACTION_FINISHED,$this->values['id']]);
                }catch (QueryException $query){
                    return $query;
                }
                break;
            default:
                $notification->body = "[Cập nhật trạng thái đơn hàng]";
                break;
        }

            $type = NotificationTypeEnum::ORDER;
            $data_type = [
                "order_id" => $this->values["id"]
            ];
            $notification->sendNotification([$user_id], $type, json_encode($data_type));

        return $res;
    }

    public function getOrder()
    {
        $user_id = Auth::user()->id;
        try {
            $orders = Order::where('buyer_id', $user_id)->get();
        } catch (QueryException $ex) {
            return response(
                [
                    "status" => "error",
                    "message" => $ex
                ], 401);
        }

        return $orders;
    }

    public function deleteAllOrder()
    {
        $user_id = Auth::user()->id;
        try {
            Order::where('buyer_id', $user_id)->delete();
        } catch (QueryException $ex) {
            return response(
                [
                    "status" => "error",
                    "message" => $ex
                ], 401);
        }

        return response(
            [
                "status" => "success",
                "message" => 'Delete order success'
            ], 200);
    }

    public function deleteOrderById()
    {
        $id = Input::get("order_id");
        $user_id = Auth::user()->id;
        try {
            $query = Order::where('id', $id)->where('buyer_id', $user_id)->delete();
            if ($query == null) {
                return response(
                    [
                        "status" => "error",
                        "message" => "Incorrect order id"
                    ], 401);
            }
        } catch (QueryException $ex) {
            return response(
                [
                    "status" => "error",
                    "message" => $ex
                ], 401);
        }

        return response(
            [
                "status" => "success",
                "message" => 'Delete order success'
            ], 200);
    }

}
