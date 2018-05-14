<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ FuzzyOperations as §§, Utils };
use MathPHP\Exception\MatrixException;

class PairwiseComparisonMatrix extends FuzzyMatrix {

    protected $pairs;
    protected $comparedWith;
    protected $weights;


    function __construct($pairs, $comparedWith, $matrix, ScaleList $sL = null){
        if(is_array($matrix)){
            foreach ($matrix as $i => $value) {
                $matrix[$i][$i] = new FuzzyNumber([1,1,1]);
            }   
            parent::__construct($matrix, $sL);
        }
        else if ($matrix instanceof FuzzyMatrix){
            foreach ($matrix->raw as $i => $value) {
                $matrix->raw[$i][$i] = new FuzzyNumber([1,1,1]);
            }
            parent::__construct($matrix->raw, $matrix->getTags());
        }
        $this->checkDimensionConsistency($pairs);
        $this->pairs = $pairs;
        $this->comparedWith = $comparedWith;
        return $this;
    }

    private function checkDimensionConsistency($pairs){
        if(count($pairs) != $this->getM())
            throw new MatrixException("Alternative count does not match with matrix x 
                                            dimensions=".count($pairs)." , expected ".$this->getM().".");
    }

    public function getComparisonInfo(){
        return ["pairs" => $this->pairs, "comparedWith" => $this->comparedWith];
    }

    // public function setWeightOfPairByIndex($index, $weight){
    //     $this->pairs->get($index)->setWeight($weight);
    // }
    public function setWeight($weight){
        $this->weights = $weight;
    }








}
?>