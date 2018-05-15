<?php
namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{   FuzzyNumber, DecisionMaker, Alternative, AlternativeList, PairwiseComparisonMatrixList as PCML, 
                        PairwiseComparisonMatrix as PCM, CriterionList, Criterion};
use PHPFuzzy\{ Utils , FuzzyOperations as §§};
use MathPHP\Exception\BadDataException;

class FuzzyMAUT extends FuzzyAHP{

    function __construct(DecisionMaker $dm, AlternativeList $aL, PCML $pcml){
        parent::__construct($dm, $aL, $pcml);
    }

    function start(){
        $this->setAllWeightsByAHP();
        $this->rankAllSubcriterias();
    }

    function rankAllSubcriterias(){
        $combinations = Utils::listPCMCombinations($this->dm);
        $subcriteriaRoadmaps = array_filter($combinations, function($c){
            $node = $this->dm->getNodeByRoadMap($c);
            if($node->children instanceof AlternativeList)
                return true;
            else return false;
        });
        $subcriteriaRoadmaps = array_map(function($e){
            array_pop($e);
            return $e;
        }, $subcriteriaRoadmaps);
    }
}

?>