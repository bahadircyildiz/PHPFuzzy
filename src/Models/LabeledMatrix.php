<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ Utils, Models\Exception\BadDataException };
use MathPHP\LinearAlgebra\Matrix;

class LabeledMatrix extends Matrix{

    protected $raw;
    protected $rowLabels;
    protected $columnLabels;

    public function __construct(array $rowLabels, array $columnLabels, array $A){
        $this->raw = $A;
        parent::__construct($A);
        self::checkIntegrity($rowLabels, $columnLabels);
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels;
    }

    private function checkIntegrity($rowLabels, $columnLabels){
        list($m, $n) = [$this->getM(), $this->getN() ]; 
        if ($this->getM() != count($rowLabels)) throw new BadDataException("Row Label count does not match, 
                                                given {${count($rowLabels)}}, expected {$m}");
        if ($this->getN() != count($columnLabels)) throw new BadDataException("Column Label count does not match, 
                                                given {${count($rowLabels)}}, expected {$n}"); 
    }

    public function __toString(){
        $stringifyRows = function($row){
            $stringifiedCells = implode("\t", array_map(function($cell){
                return (string) $cell;
            }, $row));
            $str = "[\t{$stringifiedCells}\t]";
            return $str;
        };
        $str = implode("\n", array_map( $stringifyRows, $this->getMatrix())); 
        return "\n{$str}\n";
    }
    
    public function getCellByLabelName($rowLabel, $columnLabel){
        $rowI = array_search($rowLabel, $this->rowLabels);
        $colI = array_search($rowLabel, $this->rowLabels);
        return $this->get($rowI, $colI);
    }

}
?>