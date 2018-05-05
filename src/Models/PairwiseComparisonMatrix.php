<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use MathPHP\LinearAlgebra\SquareMatrix;

class PairwiseComparisonMatrix extends SquareMatrix {

    
    function __construct($rowLabels, $columnLabels, $content, $predefinedTags){
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels;
        $this->tags = [];
        return $this;
    }

    function __toString(){
        return $this->name;
    }

    public function addCriterion(Criterion $criterion){
        $this->subcriteria[] = $criterion;
    }
?>