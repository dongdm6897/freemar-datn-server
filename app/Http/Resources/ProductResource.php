<?php

namespace App\Http\Resources;

use App\Models\MasterShipProvider;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use DB;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $owner = DB::table('users')
            ->join('products', 'products.owner_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.status_id', 'users.avatar', 'users.balance')
            ->where('products.id', '=', $this->id)
            ->first();
        $brand = DB::table('brand')
            ->join('products', 'products.brand_id', '=', 'brand.id')
            ->select('brand.id', 'brand.name')
            ->where('products.id', '=', $this->id)
            ->first();

        $category = DB::select('SELECT id,name,(SELECT name FROM category WHERE id = category_children.parent_id) AS parent_name
                                      FROM category AS category_children
                                      WHERE id IN (SELECT category_id FROM products WHERE id = ?)',[$this->id]);

        $category = collect($category)->map(function ($data) {
            if ($data->parent_name != null)
                $name = $data->parent_name . ' > ' . $data->name;
            else
                $name = $data->name;
            $results = [
                "id" => $data->id,
                "name" => $name,
            ];
            return $results;
        })->first();

        $number_of_comments = DB::table('product_comment')->where('product_id', $this->id)->count();
        $number_of_favorites = DB::table('favorite_product')->where('product_id', $this->id)->count();

        $shipping_address = null;
        if ($this->shipping_from_id != null) {
            $shipping_address = responseShippingAddress($this->shipping_from_id);
        }

        $ship_pay_method = DB::table('ship_pay_method')->where('id', '=', $this->ship_pay_method_id)->first();
        $ship_provider = MasterShipProvider::with('shipProviderService')->where('id', '=', $this->ship_provider_id)->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'reference_image_links' => $this->reference_image_links,
            'owner' => $owner,
            'brand' => $brand,
            'category' => $category,
            'is_public' => (bool)$this->is_public,
            'is_sold_out' => (bool)$this->is_sold_out,
            'tags' => $this->tags,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'commerce_fee' => $this->commerce_fee,
            'weight' => $this->weight,
            'status_id' => $this->status_id,
            'ship_time_estimation_id' => $this->ship_time_estimation_id,
            'rating' => $this->rating,
            'quantity' => $this->quantity,
            'total_reviews' => $this->total_reviews,
            'is_confirm_required' => (bool)$this->is_confirm_required,
            'is_ordering' => (bool)$this->is_ordering,
            'in_order' => Auth::check() ? new OrderResource($this->order) : null,
            'number_of_comments' => $number_of_comments,
            'number_of_favorites' => $number_of_favorites,
            'shipping_from' => $shipping_address,
            'ship_provider' => $ship_provider,
            'ship_pay_method' => $ship_pay_method,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];

    }
}
