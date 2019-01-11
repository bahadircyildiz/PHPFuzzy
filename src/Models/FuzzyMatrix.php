<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ Utils };
use MathPHP\Exceptions\MatrixException;

/**
 * Class FuzzyMatrix
 * @package PHPFuzzy\Models
 */
class FuzzyMatrix implements \Countable, \IteratorAggregate{

    protected $A;
    protected $sL;
    protected $raw;

    /**
     * @return float|int
     */
    public function count(){
        return $this->getM() * $this->getN();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator(){
        return new \ArrayIterator($this->A);
    }

    /**
     * FuzzyMatrix constructor.
     * @param array $A
     * @param ScaleList|null $sL
     */
    public function __construct(array $A, ScaleList $sL = null){
        $this->raw = $A;
        $this->sL = $sL ?? new ScaleList();
        $A = self::setParametersAsFuzzyClasses($A, $sL);
        self::validateFuzzyMatrixDimensions($A);
        $this->A = $A;
    }

    /**
     * @return string
     */
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

    /**
     * @param array $A
     * @param bool $sameFuzzyMemberLength
     */
    private static function validateFuzzyMatrixDimensions(array $A, $sameFuzzyMemberLength = false){
        $n = count($A[0]);
        foreach ($A as $i => $row) {
            if (count($row) !== $n) {
                throw new MatrixException("Row {$i} has a different column count: {${count($row)}} was expecting {$n}.");
            }
            $firstCellLength = count($row[0]);
            if($sameFuzzyMemberLength) foreach ($row as $ii => $cell){
                if(count($cell) !== $firstCellLength){
                    throw new MatrixException("Cell {$i}x{$ii} has a different member count: {${count($cell)}} was expecting {$firstCellLength}.");
                }
            }
        };
    }

    /**
     * @param array $A
     * @param $sL
     * @return array
     */
    private static function setParametersAsFuzzyClasses(array $A, $sL){
        $transformCellToFuzzyNumber = function($cell) use ($sL) {
            if (is_array($cell)){
                return new FuzzyNumber($cell);
            } else if (is_string($cell)){
                return $sL->getValueByTag($cell) ?? null;
            } else if ($cell instanceof FuzzyNumber){
                return $cell;
            }
        };
        $traveller = function($row) use ($transformCellToFuzzyNumber){
            return array_map($transformCellToFuzzyNumber, $row);
        };
        return array_map($traveller, $A);
    }

    /**
     * @return array
     */
    public function getMatrix(){
        return $this->A;
    }

    /**
     * @return int
     */
    public function getM(){
        return count($this->A[0]);
    }

    /**
     * @return int
     */
    public function getN(){
        return count($this->A);
    }

    /**
     * @return ScaleList|null
     */
    public function getTags(){
        return $this->sL;
    }

    /**
     * @param Scale $et
     */
    public function addTag(Scale $et){
        $this->sL->add($et);
        $newA = self::setParametersAsFuzzyClasses($this->A, $this->sL); 
        self::validateFuzzyMatrixDimensions($newA);
        $this->A = $newA;
    }


}
?>