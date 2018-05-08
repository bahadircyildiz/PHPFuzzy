<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ Utils };

class FuzzyMatrix{
    protected $A;
    protected $etl;

    public function __construct(array $A, EvaluationTagList $etl = null){
        $this->etl = $etl ?? new EvaluationTagList();
        $A = $this->setParametersAsFuzzyClasses($A);
        $this->validateFuzzyMatrixDimensions($A);
        $this->A = $A;
    }

    private function validateFuzzyMatrixDimensions(array $A, $sameFuzzyMemberLength = false){
        $n = count($A[0]);
        foreach ($A as $i => $row) {
            if (count($row) !== $n) {
                die("Row {$i} has a different column count: {${count($row)}} was expecting {$n}.");
            }
            $firstCellLength = count($row[0]);
            if($sameFuzzyMemberLength) foreach ($row as $ii => $cell){
                if(count($cell) !== $firstCellLength){
                    die("Cell {$i}x{$ii} has a different member count: {${count($cell)}} was expecting {$firstCellLength}.");
                }
            }
        };
    }

    private function setParametersAsFuzzyClasses(array $A){
        $transformCellToFuzzyNumber = function($cell) {
            if (is_array($cell)){
                return new FuzzyNumber($cell);
            } else if (is_string($cell)){
                return $this->etl->getValueByTag($cell) ?? null;
            } else if ($cell instanceof FuzzyNumber){
                return $cell;
            }
        };
        $traveller = function($row) use ($transformCellToFuzzyNumber){
            return array_map($transformCellToFuzzyNumber, $row);
        };
        return array_map($traveller, $A);
    }

    public function getMatrix(){
        return $this->A;
    }

    public function getM(){
        return count($this->A[0]);
    }

    public function getN(){
        return count($this->A);
    }

    public function getTags(){
        return $this->etl;
    }

    public function addTag(EvaluationTag $et){
        $this->etl->add($et);
        $newA = $this->setParametersAsFuzzyClasses($this->A); 
        $this->validateFuzzyMatrixDimensions($newA);
        $this->A = $newA;
    }


}
?>