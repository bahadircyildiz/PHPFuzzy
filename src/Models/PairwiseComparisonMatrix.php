<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use MathPHP\LinearAlgebra\SquareMatrix;

class PairwiseComparisonMatrix {

    public $rowLabels;
    public $columnLabels;
    public $value;
    private $etc;

    
    function __construct(array $rowLabels, array $columnLabels, array $matrix, EvalutionTagList $etc = null){
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels; 
        $this->value = new SquareMatrix($matrix);
        $this->etc =  $etc ?? new EvaluationTagList();
        return $this;   
    }





}
?>