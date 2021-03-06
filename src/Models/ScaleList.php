<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

class ScaleList extends Collection{

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, Scale::class);
        parent::__construct($items);
    }

    function add(Scale $tag){
        $this->items[] = $tag;
    }

    function getValueByTag(string $tag){
        $returnTag = function($e) use ($tag){
            return $e->tag == $tag; 
        };
        $result = array_values(array_filter($this->items, $returnTag));
        return $result[0]->value ?? null;
    }

}
?>