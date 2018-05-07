<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;

class CriterionList extends Collection{
    
    private $items = [];

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, Criterion::class);
        $this->checkCriteriaWeightSum($items);
        $this->items = $items;
    }

    function checkCriteriaWeightSum($items){
        $totalWeight = array_sum(Utils::objectCollectAttrRecursive($items, "weight"));
        if($totalWeight != 1){
            die("Error: Total weights in CriterionList; expected 1, result {$totalWeight}.\n");
        }
    }

    function add(Criterion $criterion){
        $this->items[] = $criterion;
    }



}
?>