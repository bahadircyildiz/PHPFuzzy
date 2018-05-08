<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

class PairwiseComparisonMatrixList extends Collection{

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, PairwiseComparisonMatrix::class);
        $this->items = $items;
    }

    function add(PairwiseComparisonMatrix $pcm){
        $this->items[] = $pcm;
    }

}
?>