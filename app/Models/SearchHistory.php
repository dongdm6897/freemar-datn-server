<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use FullTextSearch;
    protected $table = 'search_history';

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'content'
    ];
}
