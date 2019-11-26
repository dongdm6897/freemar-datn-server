<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $p_category = null;
        if($this->parent_id != null){
            $p_category = Category::find($this->parent_id);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
            'parent' => $p_category,
            'attribute_types' => $this->attributeType
        ];
    }
}
