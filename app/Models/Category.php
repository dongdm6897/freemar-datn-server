<?php

namespace App\Models;

use App\Index\CategoryIndexConfigurator;
use App\Traits\FullTextSearch;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //use Searchable;
    use FullTextSearch;
    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'name'
    ];
    public $timestamps = true;
    protected $fillable = ['parent_id', 'name', 'image', 'description','icon'];

    protected $table = "category";

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'id');
    }

    public function attributeType()
    {
        return $this->belongsToMany('App\Models\AttributeType', 'category_attribute_type', 'category_id', 'attribute_type_id')->withPivot('id')->with('attributes');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id')->with(['attributeType','children']);
    }


//    /**
//     * @var string
//     */
//    protected $indexConfigurator = CategoryIndexConfigurator::class;
//
//    /**
//     * @var array
//     */
//    protected $searchRules = [
//        //
//    ];
//
//    /**
//     * @var array
//     */
//    protected $mapping = [
//        'properties' => [
//            'name' => [
//                'type' => 'text',
//                'analyzer' => 'standard'
//            ],
//
//        ]
//    ];


    public function toSearchableArray()
    {
        $array = $this->only('name');

        return $array;
    }
}