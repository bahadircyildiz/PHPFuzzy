<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

class PairwiseComparisonMatrixList extends Collection{

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, PairwiseComparisonMatrix::class);
        $this->items = $items;
        return $this;
    }

    public function add(PairwiseComparisonMatrix $pcm){
        $this->items[] = $pcm;
    }

    public function getAllRoadMaps(){
        return array_map(function($e){
            return $e->getRoadMap();
        },$this->items);
    }

    public function findPCMByComparedWith($comparedWith){
        $toArr = Utils::iteratorToArray($this);
        $result = array_filter(function($e){
            return $e->getComparisonInfo["comparedWith"] == $comparedWith;
        }, $toArr)[0];
        return $result;
    }

}
?>