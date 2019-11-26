<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'cover_image_link' => $this->cover_image_link,
            'balance' => $this->balance,
            'status' => $this->status_id,
            'point_happy' => $this->point_happy,
            'point_just_ok' => $this->point_just_ok,
            'point_not_happy' => $this->point_not_happy,
            'selling_products' => ProductResource::collection($this->products),
        ];
    }
}
