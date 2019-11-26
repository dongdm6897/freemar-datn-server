<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Order;

use App\Models\Product;
use Auth;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use DB;
use Illuminate\Support\Facades\Input;
use function React\Promise\map;
use Symfony\Component\Console\Helper\Table;
use Illuminate\Database\QueryException;

class ProductController extends ObjectController
{
    protected $table = 'products';
    private $tags = array();
    private $attributes = array();
    private $product_id;

    public function getByOwner()
    {
        $user_id = Input::get('user_id');
        $result = $this->getProductPagination(Product::where('owner_id', $user_id));
        return $result;
    }

    public function getNewProduct()
    {
//        $datetime = Carbon::now()->subDay(10);
        $products = $this->getProductPagination(Product::where([
            ['is_public', '=', true]
        ])->orderBy('created_at', 'desc'));
        return $products;
    }


    public function getRecentlyProduct()
    {
        $res = DB::select('SELECT product_id FROM watched_product GROUP BY product_id ORDER BY created_at DESC');
        $product_id = array_map(
            function ($value) {
                return (int)$value->product_id;
            },
            $res
        );
        $products = $this->getProductPagination(Product::whereIn('id', $product_id)->where('is_public', '=', true));
        return $products;
    }

    public function getFree()
    {
        $products = $this->getProductPagination(Product::where([
            ['original_price', '=', 0],
            ['is_public', '=', true]
        ]));
        return $products;
    }

    public function getSellingProduct()
    {
        $owner_id = Input::get('user_id');
        $result = $this->getProductPagination(Product::where(['is_sold_out' => 0, 'is_ordering' => 0, 'is_public' => 1, 'owner_id' => $owner_id]));
        return $result;
    }

    public function getOrderingProduct()
    {
        $seller_id = Input::get('user_id');

        $result = $this->getProductPagination(Product::with('order')->where(
            [
                ['owner_id', '=', $seller_id],
                ['is_ordering', '=', true]
            ]
        ));

        return $result;
    }

    public function getSoldProduct()
    {
        $owner_id = Input::get('user_id');
        $result = $this->getProductPagination(Product::where(['is_sold_out' => 1, 'owner_id' => $owner_id]));
        return $result;
    }

    public function getBuyingProduct()
    {
        $buyer_id = Auth::id();

        $result = $this->getProductPagination(Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->select('products.*')
            ->where(['orders.buyer_id' => $buyer_id, 'products.is_ordering' => 1]));

        return $result;
    }

    public function getBoughtProduct()
    {
        $buyer_id = Auth::id();

        $result = $this->getProductPagination(Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->select('products.*')
            ->where(['orders.buyer_id' => $buyer_id, 'products.is_sold_out' => 1]));

        return $result;
    }

    public function getProductById()
    {

        $product_id = Input::get('product_id');
        $result = $this->getProduct(Product::where('id', '=', $product_id)->get());

        return $result;
    }

    public function getFavoriteProduct()
    {
        $user_id = Input::get('user_id');
        $result = $this->getProductPagination(Product::join('favorite_product', 'favorite_product.product_id', 'products.id')
            ->select('products.*')
            ->where(
                [
                    'user_id' => $user_id,
                ]
            )
        );
        return $result;
    }

    public function getCommentedProduct()
    {
        $user_id = Input::get('user_id');
        $result = $this->getProductPagination(
            Product::join('product_comment', 'product_comment.product_id', 'products.id')
                ->join('message', 'message.id', 'product_comment.message_id')
                ->select('products.*')
                ->where('message.sender_id', '=', $user_id)->distinct());
        return $result;
    }

    public function getProductBrand()
    {
        $brand_id = Input::get('brand_id');
        $products = $this->getProductPagination(Product::where('brand_id', '=', $brand_id));
        return $products;
    }

    public function getProductCategory()
    {
        $category_id = Input::get('category_id');
        $products = $this->getProductPagination(Product::where('category_id', '=', $category_id));
        return $products;
    }

    public function setProduct(Request $request)
    {
        $products = convertRequestBodyToArray($request)["product"];
        $this->product_id = $products['id'];
        if (!isset($products['created_at']))
            $products['created_at'] = date_create()->format('Y-m-d H:i:s');
        if (!isset($products['updated_at']))
            $products['updated_at'] = date_create()->format('Y-m-d H:i:s');

        if ($products['tags'] != null)
            $this->tags = explode(",", $products['tags']);
        else
            $this->tags = null;

        if ($products['attributes'] != null)
            $this->attributes = $products['attributes'];
        else
            $this->attributes = null;

        unset($products['tags'], $products['attributes']);
        $this->values = $products;
        $this->product_id != null ? $res = $this->update() : $res = $this->create();
        return $res;
    }

    public function getDraft()
    {
        $owner_id = Auth::user()->id;
        $results = $this->getProductPagination(Product::where([
            ['owner_id', $owner_id],
            ['is_public', false]
        ]));
        return $results;

    }

    public function getRelated()
    {
        $product_id = Input::get('product_id');
        $product = Product::find($product_id);
        $category_id = $product->category_id;
        $brand_id = $product->brand_id;
        $results = $this->getProductPagination(Product::where([
            ['category_id', '=', $category_id],
            ['id', '!=', $product_id]
        ])->orWhere(
            [
                ['brand_id', '=', $brand_id],
                ['id', '!=', $product_id]
            ]
        ));
        return $results;
    }

    public function getWatched()
    {
        $user_id = Input::get('user_id');
        $res = DB::select('SELECT product_id FROM watched_product WHERE user_id = ? ORDER BY created_at DESC', [$user_id]);
        $product_id = array_map(
            function ($value) {
                return (int)$value->product_id;
            },
            $res
        );
        $products = $this->getProductPagination(Product::whereIn('id', $product_id));
        return $products;
    }

    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }

    private function getProductPagination($query)
    {
        $page_size = Input::get('page_size') ?? config('freemar.page_size_default');

        try {
            if ($page_size == null)
                $page_size = config('freemar.page_size_default');

            $products = $query->paginate($page_size);

        } catch (QueryException $ex) {
            return $this->returnError('1', "QueryException", 401);
        }
        return new ProductCollection($products);
    }

    private function getProduct($query)
    {
        try {
            $result = $query;
            return [
                'data' => new ProductCollection($result)
            ];
        } catch (QueryException $ex) {
            return $this->returnError('1', "QueryException", 401);
        }

    }

    protected function queryTable($query)
    {
        try {
            switch ($query) {
                ///TODO combine sql
                case 'get':
                    break;
                case 'create':
                    $product_id = DB::table($this->table)->insertGetId($this->values);
                    $this->product_id = $product_id;

                    if ($this->tags != null) {
                        $this->tags = $this->mapArray($this->tags, "tag_id");
                        DB::table('product_tag')->insert($this->tags);
                    }
                    if ($this->attributes != null) {
                        $this->attributes = array_map(function ($val) {
                            $val["attribute_id"] = $val["id"];
                            $val["product_id"] = $this->product_id;
                            unset($val["id"]);
                            return $val;
                        }, $this->attributes);
                        DB::table('product_attribute')->insert($this->attributes);
                    }
                    break;
                case 'update':
                    DB::table($this->table)->where('id', $this->product_id)->update($this->values);
                    if ($this->tags != null) {
                        $this->tags = $this->mapArray($this->tags, "tag_id");
                        DB::table('product_tag')->where('product_id', $this->product_id)->delete();
                        DB::table('product_tag')->insert($this->tags);
                    }

                    if ($this->attributes != null) {
                        $this->attributes = array_map(function ($val) {
                            $val["attribute_id"] = $val["id"];
                            $val["product_id"] = $this->product_id;
                            unset($val["id"]);
                            return $val;
                        }, $this->attributes);
                        DB::table('product_attribute')->where('product_id', $this->product_id)->delete();
                        DB::table('product_attribute')->insert($this->attributes);
                    }
                    break;
                case 'delete':
                    break;
                default:
                    break;
            }
            return new ProductCollection(Product::where('id', '=', $this->product_id)->get());
        } catch (QueryException $exception) {
            return responseFail($exception);
        }
    }

    private function mapArray($array, $param)
    {
        $temp = array();
        foreach ($array as $child) {
            array_push($temp, [
                $param => (int)$child,
                'product_id' => $this->product_id
            ]);
        }
        return $temp;
    }


}
