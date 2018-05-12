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

    public function getCombinationsInList(){
        return array_map(function($e){
            return $e->getLabels();
        },$this->items);
    }

}
?>