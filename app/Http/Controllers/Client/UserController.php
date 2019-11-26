<?php

namespace App\Http\Controllers\Client;

use App\Http\Resources\SellerResource;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Config;

class UserController extends ObjectController
{
    protected $table = 'users';

    public function getUser()
    {
        $user_id = Input::get('user_id');
        $users = DB::table('users')->where('id', $user_id)->select('id', 'avatar', 'name', 'introduction')->get();
        return response(
            [
                "data" => $users
            ]
        );
    }

    public function getAllSeller()
    {
        $page_size = Input::get('page_size');
        if ($page_size == null) {
            $page_size = 10;
        }
        $users = SellerResource::collection(User::paginate($page_size));
        return $users;
    }

    public function getFollowUser()
    {
        $user_id = Input::get('user_id');

        $page_size = Input::get('page_size');
        if ($page_size == null) {
            $page_size = 10;
        }

        $followed_user_ids = DB::select('SELECT followed_user_id FROM follow WHERE user_id= ?', [$user_id]);
        $followed_user_ids = collect($followed_user_ids)->map(function ($data) {
            return $data->followed_user_id;
        })->toArray();

        $results = SellerResource::collection(User::whereIn('id', $followed_user_ids)->paginate($page_size));
        return $results;
    }

    public function getRelated()
    {
        $category_id = Input::get('category_id');

        $products = DB::select('SELECT * FROM products WHERE category_id = ? LIMIT 0,4', [$category_id]);
        return response([
            'data' => $products
        ]);
    }

    public function updateUserStatus()
    {

        $status = Input::get('status');
        $user_id = Input::get('user_id');

        $user = User::find($user_id);

        try {
            $user->status = $status;
            $user->save();
        } catch (QueryException $ex) {
            response([
                "status" => "failed",
                "message" => 'Update failed'], 401);
        }
        return response([
            "status" => "success",
            "message" => 'Update success'], 200);
    }

    //Favorite
    public function setFavoriteProduct(Request $request)
    {
        $this->validate(
            $request, [
                'product_id' => 'required|numeric',
                'is_favorite' => 'required|bool'
            ]
        );
        $user_id = Auth::user()->id;
        $product_id = $request->input('product_id');
        $is_favorite = $request->input('is_favorite');

        try {
            if ($is_favorite) {
                if (DB::table('favorite_product')
                    ->insert([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                    ])) {
                    $res = DB::select('SELECT COUNT(product_id) AS number_of_favorite FROM favorite_product WHERE product_id = ? GROUP BY product_id', [$product_id]);
                    return json_encode($res[0]);
                }
            } else {
                if (DB::table('favorite_product')->where([
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ])->delete()) {
                    $res = DB::select('SELECT COUNT(product_id) AS number_of_favorite FROM favorite_product WHERE product_id = ? GROUP BY product_id', [$product_id]);
                    if (count($res) == 0) {
                        $res['number_of_favorite'] = 0;
                        return json_encode($res);
                    }
                    return json_encode($res[0]);

                }
            }
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
                "message" => 'Create success'
            ], 200);
    }

    public function createFavoriteBrand(Request $request)
    {
        $this->validate(
            $request, [
                'brand_id' => 'required|numeric',
            ]
        );

        $user_id = Auth::user()->id;
        $brand_id = $request->input('brand_id');

        try {
            $count = DB::table('favorite_brand')->where('user_id', '=', $user_id)->count();
            if ($count < 10 && $count >= 0) {
                DB::table('favorite_brand')
                    ->insert([
                        'user_id' => $user_id,
                        'brand_id' => $brand_id,
                    ]);
            } else
                return response([
                    "status" => "error",
                    "message" => 'record length is greater than 10'], 403);
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
                "message" => 'Create success'
            ], 200);

    }

    public function deleteFavoriteBrand(Request $request)
    {
        $this->validate(
            $request, [
                'brand_id' => 'required|numeric',
            ]
        );

        $user_id = Auth::user()->id;
        $brand_id = $request->input('brand_id');

        try {
            DB::table('favorite_brand')->where([
                ['user_id', '=', $user_id],
                ['brand_id', '=', $brand_id]
            ])->delete();
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
                "message" => 'Delete success'
            ], 200);

    }

    public function createFavoriteCategory(Request $request)
    {
        $this->validate(
            $request, [
                'category_id' => 'required|numeric',
            ]
        );

        $user_id = Auth::user()->id;
        $category_id = $request->input('category_id');

        try {
            $count = DB::table('favorite_category')->where('user_id', '=', $user_id)->count();
            if ($count < 10 && $count >= 0) {
                DB::table('favorite_category')
                    ->insert([
                        'user_id' => $user_id,
                        'category_id' => $category_id,
                    ]);
            } else
                return response([
                    "status" => "error",
                    "message" => 'record length is greater than 10'], 403);
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
                "message" => 'Create success'
            ], 200);
    }

    public function deleteFavoriteCategory(Request $request)
    {
        $this->validate(
            $request, [
                'category_id' => 'required|numeric',
            ]
        );

        $user_id = Auth::user()->id;
        $category_id = $request->input('category_id');

        try {
            DB::table('favorite_category')->where([
                ['user_id', '=', $user_id],
                ['category_id', '=', $category_id]
            ])->delete();
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
                "message" => 'Delete success'
            ], 200);
    }

    public function setWatchedProduct(Request $request)
    {
        $this->validate(
            $request, [
                'product_id' => 'required|numeric',
                'is_watched' => 'required|bool'
            ]
        );
        $user_id = Auth::user()->id;
        $product_id = $request->input('product_id');
        $is_watched = $request->input('is_watched');

        try {
            if ($is_watched) {
                DB::table('watched_product')
                    ->insert([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                    ]);
            } else {
                DB::table('watched_product')->where([
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ])->delete();
            }
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
                "message" => 'Create success'
            ], 200);
    }

    public function setUser(Request $request)
    {
        $users = convertRequestBodyToArray($request);
        $this->values = $users;
        $res = $this->update();
        return $res;

    }

    /// Address
    public function getShippingAddress()
    {
        $user_id = Input::get('user_id');
        $shipping_address = DB::table('shipping_address')
            ->join('province', 'province.id', '=', 'shipping_address.province_id')
            ->join('district', 'district.id', '=', 'shipping_address.district_id')
            ->leftJoin('ward', 'ward.id', '=', 'shipping_address.ward_id')
            ->leftJoin('street', 'street.id', '=', 'shipping_address.street_id')
            ->select('shipping_address.id as id', 'name', 'phone_number', 'shipping_address.address as address',
                'province.id as province_id', 'province._name as province_name',
                'district.id as district_id', 'district._name as district_name', 'district._prefix as district_prefix',
                'ward.id as ward_id', 'ward._name as ward_name', 'ward._prefix as ward_prefix',
                'street.id as street_id', 'street._name as street_name', 'street._prefix as street_prefix')
            ->where('user_id', '=', $user_id)
            ->get();

        $shipping_address = collect($shipping_address)->map(function ($data) {
            return [
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
                    "_prefix" => $data->district_prefix
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
        });
        return $shipping_address;

    }

    public function setShippingAddress(Request $request)
    {
        $id = $request->input('id');
        $shipping_address = convertRequestBodyToArray($request);
        $this->table = 'shipping_address';
        $this->values = $shipping_address;
        if ($id != null) {
            $this->update();
            $res = $id;
        } else
            $res = $this->createGetId();
        if ($res) {
            $shipping_address = responseShippingAddress($res);
            return $shipping_address;
        }

        return responseFail("Fail");

    }

    public function deleteShippingAddress(Request $request)
    {
        $this->validate(
            $request, [
                'id' => 'required|numeric',
            ]
        );
        $this->table = "shipping_address";
        $this->delete();
    }

    public function setFollowUser(Request $request)
    {
        $follow = convertRequestBodyToArray($request);
        $this->table = 'follow';
        if ($follow['is_follow']) {
            unset($follow['is_follow']);
            $this->values = $follow;
            $res = $this->create();
        } else {
            try {
                DB::table('follow')->where([
                    ['user_id', '=', $follow['user_id']],
                    ['followed_user_id', '=', $follow['followed_user_id']]
                ])->delete();
                $res = responseSuccess();
            } catch (QueryException $exception) {
                $res = responseFail('Fail');
            }
        }
        return $res;
    }


    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }
}
