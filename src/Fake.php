<?php

namespace PHPFuzzy;
use PHPFuzzy\Models\{FuzzyNumber, FuzzyMatrix, PairwiseComparisonMatrix as PCM, Scale, ScaleList,
                    Alternative, AlternativeList, Criterion, CriterionList, DecisionMaker};
use Fakerino\Fakerino;
use MathPHP\LinearAlgebra\{ MatrixFactory };

class Fake{

    public static function FuzzyNumber(int $count = 1){
        $range = range(1, $count);
        return array_map(function($e){
            $arr = array_map(function($e){ return rand(0,100);} , range(1,3));
            sort($arr);
            return new FuzzyNumber($arr); 
        }, $range);
    }

    public static function FuzzyMatrix($row, $column, $count = 1, $sLCount = 0){
        $range = range(1, $count);
        return array_map(function($e) use($sLCount, $row, $column){
            if(is_int($sLCount))
                $sL = $sLCount != 0 ? new ScaleList(self::Scale($sLCount)) : null;
            else if($sLCount instanceof ScaleList)
                $sL = $sLCount;
            $matrix = self::Matrix($row, $column, $sL)[0];
            return new FuzzyMatrix($matrix, $sL);
        }, $range);
    }

    public static function Matrix($row, $column, $sL = null, $count = 1){
        return array_map(function($e) use ($sL, $row, $column){
            $matrix = array_fill(0, $row, array_fill(0, $column, 0));
            array_walk_recursive($matrix, function(&$cell) use ($sL){
                if($sL) if(rand(0,10) >= 6){
                    $cell = $sL->getRandom()->tag;
                }
                else $cell = self::FuzzyNumber()[0];
            });
            return $matrix;
        }, range(0, $count-1));

    }

    public static function Scale($count = 1){
        $fakerino = Fakerino::create();
        $range = range(1,$count);
        return array_map(function($e) use ($fakerino){
            return new Scale(substr($fakerino->fake("lorem"),0,3), 
                                        self::FuzzyNumber()[0]);
        },$range);

    } 

    public static function Alternative($count = 1){
        $fakerino = Fakerino::create();
        $range = range(1, $count);
        return array_map(function($e) use ($fakerino){
            return new Alternative($fakerino->fake("lorem"));
        },$range);
    }

    public static function Criterion($count = 1, $scCount = null){
        $fakerino = Fakerino::create();
        $range = range(1, $count);
        return array_map(function($e) use ($fakerino, $scCount){
            $sc = $scCount ? new CriterionList(self::Criterion($scCount)) : null; 
            return new Criterion($fakerino->fake("lorem"), $sc);
        }, $range);

    }

    public static function DecisionMaker($count = 1, $cCount = 2, $scCount = 0){
        $fakerino = Fakerino::create();
        $range = range(1, $count);
        return array_map(function($e) use ($fakerino, $cCount, $scCount){
            return new DecisionMaker(   $fakerino->fake("nameMale"), 
                                        new CriterionList(self::Criterion($cCount, $scCount))
                                    );
        },$range);
    }

    public static function PairwiseComparisonMatrix(DecisionMaker $dm, AlternativeList $aL, $type){
        // $AHPSess = FuzzyMCDM::AHP($dm, $alts);
        $combinations = Utils::listPCMCombinations($dm, $aL, $type);
        $sL = new ScaleList(Fake::Scale(3));
        return array_map(function($c) use ($sL, $dm){
            $fuzzyMatrix = Fake::FuzzyMatrix(count($c["pairs"]), count($c["pairs"]), 1, $sL);
            return new PCM( $c["pairs"], $c["comparedWith"], $fuzzyMatrix[0]);
        },$combinations);
    }
}

?>