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
            foreach ($matrix as $i => $row) {
                foreach ($row as $j => $cell){
                    if($i == $j) $matrix[$i][$j] = new FuzzyNumber([1,1,1]);
                    else $matrix[$i][$j] = 1 / $matrix[$i][$j]; 
                }
            }   
            parent::__construct($matrix, $sL);
        }
        else if ($matrix instanceof FuzzyMatrix){
            foreach ($matrix->raw as $i => $value) {
                $matrix->raw[$i][$i] = new FuzzyNumber([1,1,1]);
            }
            parent::__construct($matrix->raw, $matrix->getTags());
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