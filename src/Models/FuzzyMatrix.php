<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\{ Utils };

class FuzzyMatrix extends FuzzyNumberList {
    protected $A;


    public function __construct(array $A){
        Utils::validateArrayAsCollection($A, FuzzyNumberList);
        self::validateMatrixDimensions($A);
        $this->A = $A;
        $this->m = count($A);
    }

    private static function validateMatrixDimensions(array $A){
        $n = count($A[0]);
        foreach ($A as $i => $row) {
            if (count($row) !== $n) {
                die("Row {$i} has a different column count: {${count($row)}} was expecting {$n}.");
            }
        };
    }

    public function getMatrix(){
    }

    public function getM(){
        return 
    }


}
?>