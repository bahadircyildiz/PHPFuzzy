<?php

namespace Bahadircyildiz\PHPFuzzy;
use Bahadircyildiz\PHPFuzzy\MCDM\{FuzzyAHP};

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
    public function AHP(DecisionMaker $dm, array $alternatives){
        return new FuzzyAHP($dm, $alternatives);
    }
    
}

?>