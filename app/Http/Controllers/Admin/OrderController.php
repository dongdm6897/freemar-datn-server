<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ShippingStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected function addPaymentResult(){
        $this->validate(
            $request, [
                'product_id' => 'required|numeric'
            ]
        );
        $id = $request->input('product_id');
        $oder = new Order(
            [
                'product_id' => $id,
                'buyer_id' => Auth::user()->id,
                'discount' => $request->discount,
                'sell_price' => $request->sell_price,
                'sell_datetime' => $request->sell_datetime,
                'shipping_datetime' => $request->shipping_datetime,
                'shipping_address_id' => $request->shipping_address_id,
                'payment_method_id' => $request->payment_method_id,
                'order_status_id' => $request->order_status_id,
                'created_at' => date("Y-m-d H:i:s")
            ]);

        try {
            $oder->save();
        } catch (QueryException $ex) {
            return response(
                [
                    "status" => "error",
                    "message" => $ex
                ], 404);
        }

        return response(
            [
                "status" => "success",
                "message" => 'Create order success'
            ], 200);
    }




    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show',compact('order'));
    }


    public function destroy(Order $order)
    {
//        $brand = Brand::findOrFail($id);
        Schema::disableForeignKeyConstraints();
        $order->delete();
        Schema::enableForeignKeyConstraints();


//        return redirect()->route('brands.index')
//            ->with('success','Brand deleted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $shipping_status = ShippingStatusEnum::toArray();
        return view('orders.edit',compact('order','shipping_status'));
    }

    public function update(Request $request, Order $order)
    { $request->validate([
        'name' => 'required',
        'image' => 'required',
        'description' => 'required',
    ]);

        $order->update($request->all());

        return redirect()->route('orders.index')
            ->with('success','Order updated successfully');

    }


    public function index()
    {
        $orders = Order::query();
        if(request()->ajax())
        {
            return DataTables::eloquent($orders)
                ->addColumn('action', function($data){
                    $button = '<a href="' . route('orders.show', $data->id) . '" class="btn btn-primary btn-sm"> View</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('orders.edit', $data->id) . '" class="edit btn btn-primary btn-sm"> Update</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('orders.index');
    }


}
