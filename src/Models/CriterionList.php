<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;

class CriterionList extends Collection{

    function __construct(array $items = [], bool $checkWeight = false){
        Utils::validateArrayAsCollection($items, Criterion::class);
        $checkWeight ?? $this->checkCriteriaWeightSum($items);
        parent::__construct($items);
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