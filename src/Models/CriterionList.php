<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

/**
 * Class CriterionList
 * @package PHPFuzzy\Models
 */
class CriterionList extends Collection{

    /**
     * CriterionList constructor.
     * @param array $items
     * @param bool $checkWeight
     * @throws \Exception
     */
    function __construct(array $items = [], bool $checkWeight = false){
        Utils::validateArrayAsCollection($items, Criterion::class);
        $checkWeight ?? $this->checkCriteriaWeightSum($items);
        parent::__construct($items);
    }

    /**
     * @param $items
     */
    function checkCriteriaWeightSum($items){
        $totalWeight = array_sum(Utils::objectCollectAttrRecursive($items, "weight"));
        if($totalWeight != 1){
            die("Error: Total weights in CriterionList; expected 1, result {$totalWeight}.\n");
        }
    }

    /**
     * @param Criterion $criterion
     */
    function add(Criterion $criterion){
        $this->items[] = $criterion;
    }



}
?>