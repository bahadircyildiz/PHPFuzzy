<?php

namespace PHPFuzzy\Models;

use PHPFuzzy\{FuzzyOperations as §§, Utils};
use MathPHP\Exception\MatrixException;

/**
 * Class PairwiseComparisonMatrix
 * @package PHPFuzzy\Models
 */
class PairwiseComparisonMatrix extends FuzzyMatrix
{

    protected $pairs;
    protected $comparedWith;
    protected $dm;
    protected $weights;

    /**
     * PairwiseComparisonMatrix constructor.
     * @param $pairs
     * @param $comparedWith
     * @param $matrix
     * @param ScaleList|null $sL
     */
    function __construct($pairs, $comparedWith, $matrix, ScaleList $sL = null)
    {
        if (is_array($matrix)) {
            parent::__construct($matrix, $sL);
        } else {
            if ($matrix instanceof FuzzyMatrix) {
                parent::__construct($matrix->raw, $matrix->getTags());
            }
        }
        foreach ($this->A as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($i == $j) {
                    $this->A[$i][$j] = new FuzzyNumber([1, 1, 1]);
                }
            }
        }
        $this->pairs = $pairs;
        $this->comparedWith = $comparedWith;
        return $this;
    }

    /**
     * @param $pairs
     * @throws MatrixException
     */
    private function checkDimensionConsistency($pairs)
    {
        if (count($pairs) != $this->getM()) {
            throw new MatrixException("Pair count does not match with matrix x 
                                            dimensions=" . count($pairs) . " , expected " . $this->getM() . ".");
        }
    }

    /**
     * @param $weight
     */
    public function setWeight($weight)
    {
        $this->weights = $weight;
    }

    /**
     * @return mixed
     */
    public function getPairs()
    {
        return $this->pairs;
    }

    /**
     * @return mixed
     */
    public function getComparedWith()
    {
        return $this->comparedWith;
    }
}