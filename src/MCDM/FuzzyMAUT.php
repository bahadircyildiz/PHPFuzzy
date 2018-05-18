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
        $this->rankSubcriteriasGlobally();
        $this->rankSubcriteriasLocally();
        var_export($this->dm);
    }

    function rankSubcriteriasLocally(){
        Utils::objectArrayWalkRecursive(function($e, $indexArr){
            if(!($e instanceof Alternative)) if(count($e->children) > 0){
                $batch = iterator_to_array($e->children);
                usort($batch, function($a, $b){
                    if ($a->getWeight("local") == $b->getWeight("local")) {
                        return 0;
                    }
                    return ($a->getWeight("local") < $b->getWeight("local")) ? -1 : 1;
                });
                $sortedLocally = array_reverse($batch);
                foreach ($sortedLocally as $c_i => &$c) {
                    $c->setRank("local", $c_i+1);
                }   
            }
        }, [$this->dm], "children");
    }

    function rankSubcriteriasGlobally(){
        $combinations = Utils::listPCMCombinations($this->dm);
        $subcriteriaRoadmaps = array_filter($combinations, function($c){
            $node = $this->dm->getNodeByRoadMap($c);
            if($node->children instanceof AlternativeList)
                return true;
            else return false;
        });
        $subcriteria = array_map(function($e){
            return $this->dm->getNodeByRoadMap($e);
        }, $subcriteriaRoadmaps);
        usort($subcriteria, function($a, $b){
            if ($a->getWeight("global") == $b->getWeight("global")) {
                return 0;
            }
            return ($a->getWeight("global") < $b->getWeight("global")) ? -1 : 1;
        });
        $sortedGlobally = array_reverse($subcriteria);
        foreach ($sortedGlobally as $c_i => &$c) {
            $c->setRank("global", $c_i+1);
        }
    }
}

?>