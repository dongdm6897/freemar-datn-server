<?php

namespace App\Http\Controllers\Client;

use App\Http\Resources\ProductCollection;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CategoryCollection;
use App\Models\Product;
use App\Models\SearchHistory;
use function GuzzleHttp\Promise\queue;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use function MongoDB\BSON\toJSON;


class SearchController extends ObjectController
{

    public function searchProduct()
    {
        $data = Input::all();
        $status_ids = [];
        $brand_ids = [];
        $category_ids = [];
        $product_ids = [];
        $price_from = 0;
        $price_to = 100000000000;
        $sold_out = false;
        if ($data['brand_ids'] != 'null')
            $brand_ids = explode(',', $data['brand_ids']);

        if ($data['category_ids'] != 'null')
            $category_ids = explode(',', $data['category_ids']);

        if ($data['product_status_ids'] != 'null')
            $status_ids = explode(',', $data['product_status_ids']);

        if ($data['color_attribute_ids'] != 'null' || $data['size_attribute_ids'] != 'null') {
            $color_attribute_ids = explode(',', $data['color_attribute_ids']);
            $size_attribute_ids = explode(',', $data['size_attribute_ids']);
            $temp = DB::table('product_attribute')
                ->select('product_id')
                ->whereIn('attribute_id', array_merge($color_attribute_ids, $size_attribute_ids))
                ->get();
            $temp = collect($temp)->map(function ($data) {
                return $data->product_id;
            });
            $product_ids = $temp->toArray();
        }

        if ($data['price_from'] != 'null')
            $price_from = $data['price_from'];

        if ($data['price_to'] != 'null')
            $price_to = $data['price_to'];

        if ($data['sold_out'] != 'null')
            $sold_out = $data['sold_out'] == 'true' ? true : false;

        try {
            $search = $data['keyword'] != 'null' ? Product::search($data['keyword'])->where('is_sold_out', $sold_out)
                : Product::where('is_sold_out', (bool)$sold_out);

            $result = $search
                ->when(!empty($product_ids), function ($query) use ($product_ids) {
                    return $query->whereIn('id', $product_ids);
                })
                ->when(!empty($category_ids), function ($query) use ($category_ids) {
                    return $query->whereIn('category_id', $category_ids);
                })
                ->when(!empty($brand_ids), function ($query) use ($brand_ids) {
                    return $query->whereIn('brand_id', $brand_ids);
                })
                ->when(!empty($status_ids), function ($query) use ($status_ids) {
                    return $query->whereIn('status_id', $status_ids);
                })
                ->whereBetween('price', [$price_from, $price_to])
                ->get();
        } catch (QueryException $ex) {
            return $this->returnError($ex, "Search failed", 401);
        }

        return new ProductCollection($result);
    }

    public function searchBrand(Request $request)
    {
        $data = Input::get('data');

        try {
            $result = Brand::search($data)->get();
        } catch (QueryException $ex) {
            return $this->returnError($ex, "Search failed", 401);
        }

        return $result;
    }

    public function searchCategory(Request $request)
    {
        $data = Input::get('data');

        try {
            $result = Category::search($data)->get();
        } catch (QueryException $ex) {
            return $this->returnError($ex, "Search failed", 401);
        }

        return new CategoryCollection($result);
    }

    public function searchEverything()
    {
        $data = Input::get('data');
        try {
            $result_brand = Brand::search($data)->get();
            $result_category = Category::search($data)->get();
            $result_product = Product::search($data)->select('name')->groupBy('name')->get();
        } catch (QueryException $ex) {
            return $this->returnError($ex, "Search failed", 401);
        }

        return [
            "products" => [
                "data" => $result_product
            ],
            "brands" => [
                "data" => $result_brand
            ],
            "categories" => [
                "data" => $result_category
            ]
        ];
    }

    public function saveSearchHistory()
    {
        $content = Input::get('content');
        try {
            DB::table('search_history')
                ->insert(
                    [
                        'content' => $content,
                        'search_amount' => 1,
                        'user_id' => \Auth::id(),
                        'created_at' => date_create()->format('Y-m-d H:i:s'),
                        'updated_at' => date_create()->format('Y-m-d H:i:s')
                    ]);
            return responseSuccess();
        } catch (QueryException $ex) {
            return responseFail("Fail");
        }
    }

    public function createSearchProduct(Request $request)
    {
        $this->table = 'product_search_template';
        $this->values = convertRequestBodyToArray($request);
        $this->values['user_id'] = \Auth::id();
        $res = $this->create();
        return $res;
    }

    public function getProductSearchTmp()
    {
        $user_id = Input::get('user_id');
        $res = DB::table('product_search_template')->where('user_id', '=', $user_id)->get();
        $res = collect($res)->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name,
                'key_word' => $data->keyword,
                'price_from' => $data->price_from,
                'price_to' => $data->price_to,
                'sold_out' => (bool)$data->sold_out,
                'brand_ids' => DB::table('brand')->whereIn('id', explode(',', $data->brand_ids))->get(),
                'category_ids' => DB::table('category')->whereIn('id', explode(',', $data->category_ids))->get(),
                'color_attributes' => DB::table('attribute')->whereIn('id', explode(',', $data->color_attribute_ids))->get(),
                'size_attributes' => DB::table('attribute')->whereIn('id', explode(',', $data->size_attribute_ids))->get(),
                'product_status' => DB::table('master_product_status')->whereIn('id', explode(',', $data->product_status_ids))->get()
            ];
        });
        return $res;
    }

    public function deleteSearchProduct()
    {
        $id = Input::get('id');
        if (DB::table('product_search_template')->delete($id))
            return responseSuccess();
        return responseFail('Delete failed');
    }

    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }
}
