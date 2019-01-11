<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ FuzzyOperations as §§, Utils };
use MathPHP\Exception\MatrixException;

/**
 * Class DecisionMatrix
 * @package PHPFuzzy\Models
 */
class DecisionMatrix extends FuzzyMatrix {

    protected $cL;
    protected $aL;


    /**
     * DecisionMatrix constructor.
     * @param AlternativeList $aL
     * @param CriterionList $cL
     * @param mixed $matrix
     * @param ScaleList|null $sL
     * @throws MatrixException
     */
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

    /**
     * @param $aL
     * @param $cL
     * @throws MatrixException
     */
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