<?php

namespace App\Http\Resources;

use App\Models\OrderAssessment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $payment = DB::select(
            'SELECT * FROM payment 
                   INNER JOIN order_payment ON payment.id = order_payment.payment_id 
                   WHERE order_payment.order_id = ?', [$this->id]);

        return [
            'id' => $this->id,
            'discount' => $this->discount,
            'sell_price' => $this->sell_price,
            'payment_fee' => $this->payment_fee,
            'commerce_fee' => $this->commerce_fee,
            'shipping_fee' => $this->shipping_fee,
            'status' => $this->status,
            'shipping_address' => responseShippingAddress($this->shipping_address_id),
            'shipping_status_id' => $this->shipping_status_id,
            'ship_provider_service_id' => $this->shipping_service_id,
            'assessments' => OrderAssessment::with('detailAssessmentType')->where('order_id', '=', $this->id)->get(),
            'payment_method' => DB::table('master_payment_method')->where('id', '=', $this->payment_method_id)->first(),
            'payment' => $payment,
            'buyer' => new UserResource($this->buyer),
            'shipping_done' => $this->shipping_done,
            'return_shipping_done' => $this->return_shipping_done,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
