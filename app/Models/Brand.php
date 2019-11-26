<?php

namespace App\Models;

use App\Index\BrandIndexConfigurator;
use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class Brand extends Model
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
    protected $table = "brand";
    protected $fillable = ['name','image','description',''];


    public function product(){
        return $this->hasMany('App\Models\Product','id');
    }

    public function toSearchableArray()
    {
        $array = $this->only('name');

        return $array;
    }

//    /**
//     * @var string
//     */
//    protected $indexConfigurator = BrandIndexConfigurator::class;
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
//                'analyzer'=> 'my_custom_ngram_analyzer',
//            ],
//
//        ]
//    ];




}
