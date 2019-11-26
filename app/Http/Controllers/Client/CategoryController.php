<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $category = new Category();
        $category = Category::find($id);
        $category->parent_id = $request->input('parent_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->icon = $request->input('icon');
        $category->save();
        return response()->json($category);
    }

    /* public function setCategory(Request $request){
         $id = $request->input('id');
         if($id != null)
             $res =  $this->update($request);
         else
             $res = $this->create($request);
         return $res;
     }*/

    public function updateById(Request $request)
    {
        $category_id = Input::get('category_id');
        $category = Category::find($category_id);
        $category->parent_id = Input::get('parent_id');
        $category->name = Input::get('name');
        $category->description = Input::get('description');
        $category->icon = Input::get('icon');

        try {
            $category->save();
        } catch (QueryException $ex) {
            return $this->returnError('1', "Update failed", 401);
        }

        return response([
            "status" => "success",
            "message" => 'Create success'], 200);
    }

    public function getAllCategory()
    {
//        $categories = new CategoryCollection(Category::with('childs')->get());
        $categories = Category::with(['attributeType','children'])->where('parent_id','=',null)->get();
        if (!$categories)
            return $this->returnError(1, 'error', 401);
        return $categories;
    }

    public function getFeaturedCategory()
    {
    }

    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }

}
