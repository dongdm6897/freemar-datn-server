<?php

namespace App\Models;

use App\Index\ProductIndexConfigurator;
use App\Traits\FullTextSearch;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use Searchable;
    use FullTextSearch;
    public $timestamps = true;
    protected $fillable = ['name', 'image', 'owner_id', 'brand_id', 'category_id', 'represent_image_link', 'reference_image_links', 'price', 'commerce_fee_id', 'is_sold_out', 'is_public', 'original_price', 'new_product_refer_price', 'new_product_refer_link', 'status_id', 'quantity', 'description', 'target_gender_id', 'attribute_size_id', 'ship_provider_id'];

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'name'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'product_id');

    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function attribute()
    {
        return $this->belongsToMany('App\Models\Attribute', 'product_attribute', 'product_id', 'attribute_id');
    }
    public function shippingFrom()
    {
        return $this->hasOne('App\Models\ShippingAddress', 'shipping_from_id');
    }
}