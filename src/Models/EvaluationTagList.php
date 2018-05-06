<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;

class EvaluationTagList extends Collection{
    
    private $items = [];

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, EvaluationTag);
        $this->items = $items;
    }

    function add(EvaluationTag $tag){
        $this->items[] = $tag;
    }

}
?>