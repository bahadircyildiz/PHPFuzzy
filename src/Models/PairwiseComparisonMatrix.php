<?php

namespace PHPFuzzy\Models;

<<<<<<< HEAD
class PairwiseComparisonMatrix extends FuzzyMatrix {

    protected $mLabels;
    protected $nLabels;
    protected $criterion;

    
    function __construct(array $mLabels, array $nLabels, Criterion $c = null, array $matrix, EvalutionTagList $etl = null){
        parent::__construct($matrix, $etl);
        $this->checkLabelCount($mLabels, $nLabels);
        $this->criterion = $c ?? null;
        $this->mLabels = $mLabels;
        $this->nLabels = $nLabels;
        return $this;
=======
class PairwiseComparisonMatrix extends FuzzyMatrix{
    public $rowLabels;
    public $columnLabels;

    function __construct(array $rowLabels, array $columnLabels, array $A, EvaluationTagList $etl = null){
        parent::__construct($A, $etl);
        $this->checkLabelsCount($rowLabels, $columnLabels);
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels;
>>>>>>> feature/PairwiseComparisonMatrix
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