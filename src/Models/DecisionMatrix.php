<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ FuzzyOperations as §§, Utils };
use MathPHP\Exception\MatrixException;

class DecisionMatrix extends FuzzyMatrix {

    protected $cL;
    protected $aL;


    function __construct(AlternativeList $aL, CriterionList $cL, mixed $matrix, ScaleList $sL = null){
        if(is_array($matrix))   parent::__construct($matrix, $sL);
        else if ($matrix instanceof FuzzyMatrix){
            parent::__construct($matrix->raw, $matrix->getTags());
        }
        $this->checkDimensionConsistency($aL, $cL);
        $this->cL = $cL;
        $this->aL = $aL;
        return $this;
    }

    private function checkDimensionConsistency($aL, $cL){
        $A = $this->A;
        if(count($aL) != $A->getM())
            throw new MatrixException("Alternative count does not match with matrix x dimension 
                                            m=".count($aL)." , expected ".$A->getM().".");
        if(count($cL) != $A->getN())
            throw new MatrixException("Criteria count does not match with matrix x dimension 
                                            n=".count($cL)." , expected ".$A->getN().".");

    }








}
?>