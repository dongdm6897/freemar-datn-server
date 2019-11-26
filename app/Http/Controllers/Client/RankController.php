<?php

namespace App\Http\Controllers\Client;


use DB;

class RankController extends ObjectController
{
    public function getAll()
    {

        $res = DB::select('SELECT category.name AS category_name,category_id,brand.name AS brand_name,brand_id,table_view.image
                             FROM category,brand,(SELECT category_id,brand_id,MIN(image) as image FROM products GROUP BY category_id,brand_id ORDER BY (SUM(views)+SUM(is_sold_out)) DESC LIMIT 30 ) AS table_view 
                             WHERE category.id = table_view.category_id AND brand.id=table_view.brand_id ;');
        return $res;
    }
}