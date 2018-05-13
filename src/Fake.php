<?php

namespace PHPFuzzy;
use PHPFuzzy\Models\{FuzzyNumber, FuzzyMatrix, PairwiseComparisonMatrix as PCM, EvaluationTag, EvaluationTagList,
                    Alternative, AlternativeList, Criterion, CriterionList, DecisionMaker};
use Fakerino\Fakerino;

class Fake{

    public static function FuzzyNumber(int $count = 1){
        $range = range(1, $count);
        return array_map(function($e){
            $arr = array_map(function($e){ return rand(0,100);} , range(1,3));
            sort($arr);
            return new FuzzyNumber($arr); 
        }, $range);
    }

    public static function FuzzyMatrix($row, $column, $count = 1, $etCount = 0){
        $range = range(1, $count);
        return array_map(function($e) use($etCount, $row, $column){
            if(is_int($etCount))
                $etl = $etCount != 0 ? new EvaluationTagList(self::EvaluationTag($etCount)) : null;
            else if($etCount instanceof EvaluationTagList)
                $etl = $etCount;
            $matrix = self::Matrix($row, $column, $etl)[0];
            return new FuzzyMatrix($matrix, $etl);
        }, $range);
    }

    public static function Matrix($row, $column, $etl = null, $count = 1){
        $range = range(1, $count);
        $rowRange = range(1, $row);
        $columnRange = range(1, $column);
        return array_map(function($e) use ($etl, $rowRange, $columnRange){
            return array_map(function($e)use ($etl, $rowRange){
                return array_map(function($e)use ($etl){
                    if($etl) if(rand(0,10) >= 6){
                        return $etl->getRandom()->tag;
                    }
                    return self::FuzzyNumber()[0];
                }, $rowRange);
            }, $columnRange);
        }, $range);
    }

    public static function EvaluationTag($count = 1){
        $fakerino = Fakerino::create();
        $range = range(1,$count);
        return array_map(function($e) use ($fakerino){
            return new EvaluationTag(substr($fakerino->fake("lorem"),0,3), 
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

    // public static function PairwiseComparisonMatrix(DecisionMaker $dm, AlternativeList $alts){
    //     $AHPSess = FuzzyMCDM::AHP($dm, $alts);
    //     $combinations = $AHPSess->listPCMCombinations();
    //     $etl = new EvaluationTagList(Fake::EvaluationTag(3));
    //     return array_map(function($labelOptions)use ($etl){
    //         $fuzzyMatrix = Fake::FuzzyMatrix(   count($labelOptions["m"]), 
    //                                             count($labelOptions["n"]), 1, $etl);
    //         return new PCM( $labelOptions, $fuzzyMatrix[0]);
    //     },$combinations);
    // }
}

?>