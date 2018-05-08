<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

class CriterionList extends Collection{

<<<<<<< HEAD
    function __construct(array $items = [], bool $checkWeight = false){
        Utils::validateArrayAsCollection($items, Criterion::class);
        $checkWeight ?? $this->checkCriteriaWeightSum($items);
        parent::__construct($items);
=======
    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, Criterion::class);
        $this->checkCriteriaWeightSum($items);
        $this->items = $items;
>>>>>>> feature/PairwiseComparisonMatrix
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