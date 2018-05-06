<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class PairwiseComparisonMatrix {

    public $rowLabels;
    public $columnLabels;
    public $value;
    private $etc;

    
    function __construct(array $rowLabels, array $columnLabels, FuzzyMatrix $matrix, EvalutionTagList $etc = null){
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels; 
        $this->value = $matrix;
        $this->etc =  $etc ?? new EvaluationTagList();
        return $this;   
    }







}
?>