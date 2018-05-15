<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ FuzzyOperations as §§, Utils };
use MathPHP\Exception\MatrixException;

class PairwiseComparisonMatrix extends FuzzyMatrix {

    // protected $pairs;
    // protected $comparedWith;
    protected $roadMap;
    protected $dm;
    protected $weights;


    function __construct($roadmap, $matrix, ScaleList $sL = null){
        if(is_array($matrix)){
            parent::__construct($matrix, $sL);
        }
        else if ($matrix instanceof FuzzyMatrix){
            parent::__construct($matrix->raw, $matrix->getTags());
        }
        foreach ($this->A as $i => $row) {
            foreach ($row as $j => $cell){
                if($i == $j) $this->A[$i][$j] = new FuzzyNumber([1,1,1]);
            }
        }   
        $this->roadMap = $roadmap;
        return $this;
    }

    private function checkDimensionConsistency($pairs){
        if(count($pairs) != $this->getM())
            throw new MatrixException("Alternative count does not match with matrix x 
                                            dimensions=".count($pairs)." , expected ".$this->getM().".");
    }

    public function setWeight($weight){
        $this->weights = $weight;
    }

    public function getRoadMap(){
        return $this->roadMap;
    }

}
?>