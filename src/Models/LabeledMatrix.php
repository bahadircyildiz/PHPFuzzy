<?php

namespace PHPFuzzy\Models;

use PHPFuzzy\{Utils, Models\Exception\BadDataException, WolframAlphaHelper};
use MathPHP\LinearAlgebra\{Matrix, MatrixFactory};

/**
 * Class LabeledMatrix
 * @package PHPFuzzy\Models
 */
class LabeledMatrix extends Matrix
{

    protected $raw;
    protected $rowLabels;
    protected $columnLabels;

    /**
     * LabeledMatrix constructor.
     * @param array $rowLabels
     * @param array $columnLabels
     * @param array|null $A
     * @throws \MathPHP\Exception\BadDataException
     */
    public function __construct(array $rowLabels, array $columnLabels, array $A = null)
    {
        $this->raw = $A;
        parent::__construct($A ?? self::matrixFill(count($rowLabels), count($columnLabels), 0));
        self::checkIntegrity($rowLabels, $columnLabels);
        $this->rowLabels = $rowLabels;
        $this->columnLabels = $columnLabels;
    }

    /**
     * @param $cntRow
     * @param $cntCol
     * @param $value
     * @return array
     */
    public static function matrixFill($cntRow, $cntCol, $value)
    {
        return array_fill(0, $cntCol, array_fill(0, $cntRow, $value));
    }

    /**
     * @param $rowLabels
     * @param $columnLabels
     */
    private function checkIntegrity($rowLabels, $columnLabels)
    {
        list($m, $n) = [$this->getM(), $this->getN()];
        if ($this->getM() != count($rowLabels)) {
            throw new BadDataException("Row Label count does not match, 
                                                given {${count($rowLabels)}}, expected {$m}");
        }
        if ($this->getN() != count($columnLabels)) {
            throw new BadDataException("Column Label count does not match, 
                                                given {${count($rowLabels)}}, expected {$n}");
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $stringifyRows = function ($row) {
            $stringifiedCells = implode("\t", array_map(function ($cell) {
                return (string)$cell;
            }, $row));
            $str = "[\t{$stringifiedCells}\t]";
            return $str;
        };
        $str = implode("\n", array_map($stringifyRows, $this->getMatrix()));
        return "\n{$str}\n";
    }

    /**
     * @param $rowLabel
     * @param $columnLabel
     * @return number
     * @throws \MathPHP\Exception\MatrixException
     */
    public function getCellByLabelName($rowLabel, $columnLabel)
    {
        $rowI = array_search($rowLabel, $this->rowLabels);
        $colI = array_search($columnLabel, $this->columnLabels);
        return $this->get($rowI, $colI);
    }

    /**
     * @param $rowLabel
     * @param $columnLabel
     * @param $value
     */
    public function setCellByLabelName($rowLabel, $columnLabel, $value)
    {
        $rowI = array_search($rowLabel, $this->rowLabels);
        $colI = array_search($columnLabel, $this->columnLabels);
        return $this->set($rowI, $colI, $value);
    }

    /**
     * @param $rowI
     * @param $colI
     * @param $value
     */
    public function set($rowI, $colI, $value)
    {
        $this->A[$rowI][$colI] = $value;
    }

    /**
     * @return array
     */
    public function getRowLabels()
    {
        return $this->rowLabels;
    }

    /**
     * @return array
     */
    public function getColumnLabels()
    {
        return $this->columnLabels;
    }

    /**
     * @return LabeledMatrix
     * @throws \MathPHP\Exception\BadDataException
     */
    public function limit()
    {
        //Limit[MatrixPower[{{0.9,0.2},{0.1,0.8}},n],n,Infinity]
        $wolframMatrix = WolframAlphaHelper::convertMatrix($this->A);
        $query = "Limit[MatrixPower[{$wolframMatrix},n],n,Infinity]";
        $result = WolframAlphaHelper::query($query);
        $result = explode("=", $result->queryresult->pods[0]->subpods[0]->plaintext);
        $result = str_replace(["(", ")"], "", end($result));
        $result = array_map(function ($rows) {
            return array_map(function ($cell) {
                return (float)$cell;
            }, explode("|", $rows));
        }, explode("\n", $result));
        return new self($this->rowLabels, $this->columnLabels, $result);
    }

    /**
     * @return LabeledMatrix
     * @throws \MathPHP\Exception\BadDataException
     * @throws \MathPHP\Exception\IncorrectTypeException
     */
    public function normalize()
    {
        $transposedMatrix = $this->transpose()->getMatrix();
        $weightedMatrixTransposed = MatrixFactory::create(array_map(function ($column) {
            return Utils::normalize($column);
        }, $transposedMatrix));
        return new self($this->getRowLabels(), $this->getColumnLabels(),
            $weightedMatrixTransposed->transpose()->getMatrix());
    }
}

?>

Limit[MatrixPower[{{0,0,0,0,0,0,0,0}, {0,0,0,0,0,0,0,0},{0,0,0,0,0,0,0,0}, {0,0,0,0,0,0,0,0},{0,0,0,0,0,0,0,0}, {0,0,0,0,0,0,0,0},{0,0,0,0,0,0,0,0}, {0,0,0,0,0,0,0,0}}, n],n ,Infinity]