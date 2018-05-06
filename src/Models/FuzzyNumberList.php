<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;

class FuzzyNumberList extends Collection{
    
    private $items = [];

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, FuzzyNumber::class);
        $this->items = $items;
    }

    function add(FuzzyNumber $fn){
        $this->items[] = $fn;
    }

}
?>