<?php

namespace App\Index;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class ProductIndexConfigurator extends IndexConfigurator
{
    protected $name = "product_index";
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        'analysis' => [
            'analyzer'=>[
                'my_custom_ngram_analyzer'=>[
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => ['lowercase']
                ]
            ],
            'tokenizer' => [
                'my_tokenizer' =>[
                    'type'=>'ngram',
                    'min_gram'=> 2,
                    'max_gram' => 5
                ]
            ]
        ]
    ];
}