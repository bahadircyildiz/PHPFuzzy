<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class EvaluationTagCollection extends Collection{
    
    private $items = [];

    function __construct(array $items){
        $this->items = $items;
    }

    function add(EvaluationTag $tag){
        $this->items[] = $tag;
    }

}
?>