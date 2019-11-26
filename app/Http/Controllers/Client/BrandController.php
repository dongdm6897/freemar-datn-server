<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class BrandController extends Controller
{

    public function create(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->image = $request->input('image');
        $brand->description = $request->input('description');
        $brand->save();
        return response()->json($brand);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }


    public function destroy(Brand $brand, $id)
    {
        Brand::destroy($id);
    }

    public function updateById(Request $request)
    {
        $brand_id = Input::get('brand_id');
        $name = Input::get('name');
        $image = Input::get('image');
        $description = Input::get('description');
        $brand = Brand::find($brand_id);
        $brand->name = $name;
        $brand->image = $image;
        $brand->description = $description;
        try {
            $brand->save();
        } catch (QueryException $ex) {
            return $this->returnError('1', "Update failed", 401);
        }

        return response([
            "status" => "success",
            "message" => 'Create success'], 200);

    }


    public function getAllBrand()
    {
        $brands = new BrandCollection(Brand::all());

        if (!$brands)
            return $this->returnError(1, 'error', 401);
        return $brands;
    }

    public function getFeaturedBrand()
    {
    }

    public function getProductBrand(Request $request)
    {
        $brand_id = Input::get('brand_id');
        $result = Product::where('brand_id', '=', $brand_id)
            ->get();

        if (!$result)
            $this->returnError('1', 'error', 404);
        return new ProductCollection($result);
    }

    public function getFavoriteBrand(Request $request)
    {
        $user_id = Input::get('user_id');
        $fv_brands = Brand::join('favorite_brand', 'favorite_brand.brand_id', 'brand.id')
            ->select('brand.*')
            ->where('favorite_brand.user_id', $user_id)
            ->get();
        if ($fv_brands != null) {
            return new BrandCollection($fv_brands);
        }
        return $this->returnError(1, 'error', 401);

    }

    protected function returnError($code, $message, $status)
    {
        return response([
            "code" => $code,
            "message" => $message
        ], $status);
    }


}
