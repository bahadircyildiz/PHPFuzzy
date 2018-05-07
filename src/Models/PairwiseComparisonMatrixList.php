<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;

class PairwiseComparisonMatrixList extends Collection{

    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, PairwiseComparisonMatrix::class);
        parent::__construct($items);
    }

    function add(PairwiseComparisonMatrix $pcm){
        $this->items[] = $pcm;
    }

}
?>