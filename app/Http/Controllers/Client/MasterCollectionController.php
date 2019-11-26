<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MasterCollection;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;

class MasterCollectionController extends Controller
{
    public function getAllCollection()
    {
        {
            $collections = MasterCollection::all();

            if (!$collections)
                return $this->returnError(1, 'error', 404);
            return response([
                'data'=>$collections
            ]);
        }
    }

    public function getProductCollection()
    {
        {
            $collection_id = Input::get('collection_id') ?? 0;
            $page = Input::get('page') ?? 1;
            $page_size = Input::get('page_size') ?? config('freemar.page_size_default');
            try {
                $search_keywords = DB::table('master_collection')->select('search_keywords')->where('id','=',$collection_id)->first();
                if($search_keywords != null)
                {
                    $products = DB::select('SELECT id,name,price,image FROM products WHERE MATCH(name) AGAINST(?) LIMIT ?,?',
                        [$search_keywords->search_keywords, $page, $page_size]);

                    return response([
                        'data' => $products,
                        'current_page' => $page,
                        'per_page' => $page_size
                    ]);
                }
            } catch (QueryException $exception) {
                return $this->returnError(1, 'error', 404);
            }

        }
        return responseFail('error');
    }

    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }
}
