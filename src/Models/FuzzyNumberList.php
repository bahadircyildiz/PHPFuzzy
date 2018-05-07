<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;

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