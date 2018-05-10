<?php

namespace PHPFuzzy;
use PHPFuzzy\MCDM\{FuzzyAHP};
use PHPFuzzy\Models\{ DecisionMaker,  AlternativeList, PairwiseComparisonMatrixList as PCML };

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
    public function AHP(DecisionMaker $dm, AlternativeList $alternatives, PCML $pcml = null){
        return new FuzzyAHP($dm, $alternatives, $pcml);
    }

    private function checkParameterConsistency(DecisionMaker $dm, AlternativeList $alternatives){
        $nameArray = array_merge( [ $dm->name ],
            Utils::objectCollectAttrRecursive($dm->criteria, "name", "subcriteria")
            );
        $nameArray = array_merge($nameArray,
            Utils::objectCollectAttrRecursive($alternatives, "name")
        );
        $sortedNameArray = array_unique($nameArray);
        if(count($sortedNameArray) != count($nameArray)){
            $implodedNameArray = implode(',', $nameArray); 
            die("Duplicate names found in given DecisionMaker and Alternatives {$implodedNameArray}.\n");
        }
        return $nameArray;

    }
    
}

?>