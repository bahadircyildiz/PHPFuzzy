<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class DecisionMaker {

    protected $name;
    protected $criteria;
    protected $alts;
    protected $pcm;
    protected $pcmCombinations;

    function __construct(string $name, CriterionList $criteria, 
                        AlternativeList $alts 
                        // PairwiseComparisonMatrixList $pcm = null
                        ){
        $this->criteria = $criteria;
        $this->alts = $alts;
        $this->name = $name;
        // $this->pcmCombinations = $this->listPCMCombinations($criteria, $alts);
    }

    function __toString(){
        return "DecisionMaker ".$this->name;
    }

    public function listPCMCombinations(){

        $CtoCmatches = function($cL, $a, &$r = []) use (&$CtoCmatches){
            $tempArray = array_map(function($e){ return (string) $e; }, iterator_to_array($cL));
            $r[] = [ $tempArray, $tempArray ];
            foreach ($cL as $c) {
                if(count($c->subcriteria) > 0)
                    $CtoCmatches($c->subcriteria, $a, $r);
                else {
                    $tempArray = array_map(function($e){ return (string) $e; }, iterator_to_array($a));
                    $r[] = [ $tempArray, $tempArray, (string) $c];
                }
            };
            return $r;
        };

        return $CtoCmatches($this->criteria, $this->alts);
    }



    
}

?>
