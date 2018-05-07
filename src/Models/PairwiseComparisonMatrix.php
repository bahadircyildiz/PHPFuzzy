<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class PairwiseComparisonMatrix extends FuzzyMatrix{
    public $rowLabels;
    public $columnLabels;

    function __construct(array $rowLabels, array $columnLabels, array $A, EvaluationTagList $etl = null){
        parent::__construct($A, $etl);
        $this->checkLabelsCount($rowLabels, $columnLabels);
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels;
    }

    private function checkLabelsCount(array $rowLabels, array $columnLabels){
        if($this->getM() != count($rowLabels))
            die("Error; Row Label count doesn't match with Matrix, 
                given {${count($rowLabels)}}, expected {${$this->getM()}}");
        if($this->getN() != count($columnLabels))
            die("Error; Column Label count doesn't match with Matrix, 
                given {${count($columnLabels)}}, expected {${$this->getN()}}");
    }
}
?>