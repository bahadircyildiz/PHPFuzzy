<?php

namespace PHPFuzzy;
use PHPFuzzy\MCDM\{FuzzyAHP, FuzzyMAUT};
use PHPFuzzy\Models\{ DecisionMaker,  AlternativeList, PairwiseComparisonMatrixList as PCML };
use MathPHP\Exception\{ BadDataException };

    /**
    *   Fuzzy Multicriteria Decision Making Class
    *  
    *   This class contains Fuzzy Multicriteria Decision Making algorithms such as AHP, ANP, Vikor.
    *
    *   @author Bahadir Can Yildiz
    */

class FuzzyMCDM{
    /**
    *   Fuzzy AHP Method 
    *
    *   Returns Fuzzy Analytical Hierarchy Process Result by using Chang's Extent Analysis. 
    *
    *   @param array $Criteria A matrix to gives weights related to the criterias and subcriterias.
    * 
    *   @param array 
    *
    * @return
    */
    public static function AHP(DecisionMaker $dm, AlternativeList $alternatives, PCML $pcml = null){
        return new FuzzyAHP($dm, $alternatives, $pcml);
    }
    
    public static function MAUT(DecisionMaker $dm, AlternativeList $alternatives, PCML $pcml = null){
        return new FuzzyMAUT($dm, $alternatives, $pcml);
    }

    private static function checkParameterConsistency(DecisionMaker $dm, AlternativeList $alternatives){
        $nameArray = array_merge( [ $dm->name ],
            Utils::objectCollectAttrRecursive($dm->criteria, "name", "children")
            );
        $nameArray = array_merge($nameArray,
            Utils::objectCollectAttrRecursive($alternatives, "name")
        );
        $sortedNameArray = array_unique($nameArray);
        if(count($sortedNameArray) != count($nameArray)){
            $implodedNameArray = implode(',', $nameArray); 
            throw new BadDataException("Duplicate names found in given DecisionMaker and Alternatives {$implodedNameArray}.\n");
        }
        return $nameArray;

    }
    
}

?>