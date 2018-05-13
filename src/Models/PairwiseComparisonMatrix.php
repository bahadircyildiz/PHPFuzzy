<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ FuzzyOperations as §§, Utils };
use MathPHP\Exception\BadDataException;

class PairwiseComparisonMatrix extends FuzzyMatrix {

    protected $pairs;
    protected $comparedWith;
    protected $weight;


    function __construct(mixed $pair, mixed $comparedWith, mixed $matrix, EvaluationTagList $etl = null){
        if(is_array($matrix))   parent::__construct($matrix, $etl);
        else if ($matrix instanceof FuzzyMatrix){
            parent::__construct($matrix->raw, $matrix->getTags());
        }
        $this->checkDimensionConsistency($pairs);
        return $this;
    }

    private function checkDimensionConsistency($pairs){
        $A = $this->A;
        if(count($pair) != $A->getM())
            throw new BadDataException("Alternative count does not match with matrix x 
                                            dimensions=".count($pairs)." , expected ".$A->getM().".");
    }

    public function getComparisonInfo(){
        return (object) ["pairs" => $this->pairs, "comparedWith" => $this->comparedWith];
    }








}
?>