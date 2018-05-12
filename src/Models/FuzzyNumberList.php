<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

class FuzzyNumberList extends Collection{

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, FuzzyNumber::class);
        parent::__construct($items);
    }

    function add(FuzzyNumber $fn){
        $this->items[] = $fn;
    }

}
?>