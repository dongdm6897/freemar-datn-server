<?php

namespace App\Http\Controllers\Client;

use App\Enums\NotificationTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\ShipProviderEnum;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\Province;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\Ward;
use App\Notifications\FreeMarNotification;
use Auth;
use DB;
use GuzzleHttp\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class PaymentController extends ObjectController
{
    protected $table = 'payment';

    public function createPayment(Request $request)
    {
        $this->values = convertRequestBodyToArray($request);
        $this->values['user_id'] = Auth::id();
        if (array_key_exists('order_id', $this->values)) {
            $order_id = $this->values['order_id'];
            unset($this->values['order_id']);
        }
        $res = $this->createGetId();

        if ($res && isset($order_id)) {
            if (DB::table('order_payment')->insert([
                'order_id' => $order_id,
                'payment_id' => $res
            ])) {
                DB::table('orders')->where('id', '=', $order_id)->update([
                    'status_id' => OrderStatusEnum::ORDER_PAID
                ]);
//                $this->createShippingOrder($this->values['order_id']);
                if ($this->values['payment_method_id'] == PaymentMethodEnum::BB_ACCOUNT) {
                    $user = Auth::user();
                    $balance = $user->balance - $this->values['amount'];
                    $user->balance = $balance;
                    $user->save();
                }
                return responseSuccess();
            }

            return responseFail('Insert order_payment');

        } else if ($res && !isset($order_id)) {
            $user = Auth::user();
            $balance = $user->balance + $this->values['amount'];
            $user->balance = $balance;
            $user->save();
            return responseSuccess();
        }

        return responseFail('Insert payment');

    }

    public function getPayment(Request $request)
    {
        $userId = Auth::id();
        $page = $request->input('page');
        $page = $page == 0 ? $page : $page - 1;
        $pageSize = $request->input('page_size');
        $res = DB::select(
            'SELECT *
                   FROM payment 
                   WHERE user_id = ? LIMIT ?,?
                   ', [$userId, $page * $pageSize, $pageSize]);
        return $res;
    }

    public function getRevenue()
    {
        $userId = Auth::id();
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-31');

        $res = DB::select(
            'SELECT payment_type_id, SUM(amount) AS amount,COUNT(id) AS number FROM (SELECT *
                   FROM payment 
                   WHERE user_id = ? AND  date_format(created_at, \'%Y-%m-%d\' ) >= ? AND date_format(created_at, \'%Y-%m-%d\' ) <= ? 
                   ) AS filter_payment GROUP BY payment_type_id', [$userId, $startDate, $endDate]);
        $revenue = 0;
        $boughtAmount = 0;
        $quantitySold = 0;
        $quantityRefunded = 0;
        $amountWithdrawn = 0;
        $amountDeposit = 0;
        $quantityBought = 0;

        foreach ($res as $value) {
            if ($value->payment_type_id == PaymentTypeEnum::PAY_FOR_SELLER) {
                $revenue = $value->amount;
                $quantitySold = $value->number;
                continue;
            }
            if ($value->payment_type_id == PaymentTypeEnum::BUYER_PAY) {
                $boughtAmount = $value->amount;
                $quantityBought = $value->number;
                continue;
            }
            if ($value->payment_type_id == PaymentTypeEnum::REFUND) {
                $quantityRefunded = $value->number;
                continue;
            }
            if ($value->payment_type_id == PaymentTypeEnum::WITHDRAW) {
                $amountWithdrawn = $value->amount;
                continue;
            }
            if ($value->payment_type_id == PaymentTypeEnum::DEPOSIT) {
                $amountDeposit = $value->amount;
                continue;
            }
            continue;
        }

        return [
            'revenue' => $revenue,
            'bought_amount' => $boughtAmount,
            'quantity_bought' => $quantityBought,
            'quantity_sold' => $quantitySold,
            'quantity_refunded' => $quantityRefunded,
            'amount_withdrawn' => $amountWithdrawn,
            'amount_deposit' => $amountDeposit
        ];
    }


    public function getRevenueChart(Request $request)
    {
        $userId = Auth::id();
        $paymentTypeId = $request->input('payment_type_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $res = DB::select('SELECT EXTRACT(month from date_format(created_at,\'%Y-%m-%d\' )) as month,EXTRACT(year from date_format(created_at,\'%Y-%m-%d\' )) as year, sum(amount) AS amount
                                FROM payment
                                WHERE user_id = ? AND payment_type_id = ? AND  
                                      date_format(created_at,  \'%Y-%m-%d\' ) >= ? AND date_format(created_at, \'%Y-%m-%d\' ) <= ?
                                GROUP BY month,year
                                ORDER BY year,month ASC;', [$userId, $paymentTypeId, $startDate, $endDate]);
        return $res;
    }

    public function requestWithdrawal(Request $request)
    {
        $request_withdrawal = convertRequestBodyToArray($request);
        $users= Auth::user();
        //Insert data
        if ($users) {
            $money_account = $request_withdrawal['money_account'];
            if($money_account['money_account_id'] != 0)
            {
                $money_account_id = $money_account['money_account_id'];
            }else{
                unset($money_account['money_account_id']);
                $money_account['user_id'] = 1;
                $money_account['created_at'] = $request_withdrawal['created_at'];
                $money_account['updated_at'] = $request_withdrawal['updated_at'];
                $this->table = "money_account";
                $this->values = $money_account;
                $money_account_id = $this->createGetId();
            }

            $payment = $request_withdrawal['payment'];
            $payment['user_id'] = 1;
            $payment['created_at'] = $request_withdrawal['created_at'];
            $payment['updated_at'] = $request_withdrawal['updated_at'];
            $this->table = "payment";
            $this->values = $payment;
            $payment_id = $this->createGetId();

            if ($money_account_id && $payment_id) {
                $this->table = "withdraw_request";
                $this->values = [
                    'money_account_id' => $money_account_id,
                    'payment_id' => $payment_id,
                    'created_at' => $request_withdrawal['created_at'],
                    'updated_at' => $request_withdrawal['updated_at']
                ];
                $this->create();
                $users->balance = $users->balance - ($payment['amount'] + $payment['fee']);
                $users->save();
                return response([
                    'status' => true,
                    'money_account_id' => $money_account_id
                ]);
            }
        }
        return response([
            'status' => false,
            'message' => "Create fail"
        ]);

    }
}
