<?php
namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{ DecisionMaker, AlternativeList, PairwiseComparisonMatrixList};


class FuzzyAHP{
    protected $dm;
    protected $alternatives;
    /**
     * Pairwise Comparion Matrix List
     */
    protected $pcml;

    function __construct(DecisionMaker $dm, AlternativeList $alternatives, PairwiseComparisonMatrixList $pcml = null){
        $this->dm = $dm;
        $this->alternatives = $alternatives;
        $this->pcml = $pcml ?? new PairwiseComparisonMatrixList();
    }

    public function listPCMCombinations(){

        $CtoCmatches = function($cL, $a, &$r = []) use (&$CtoCmatches){
            $tempArray = array_map(function($e){ return (string) $e; }, iterator_to_array($cL));
            $r[] = (object) [ "m" => $tempArray, "n" => $tempArray ];
            foreach ($cL as $c) {
                if(count($c->subcriteria) > 0)
                    $CtoCmatches($c->subcriteria, $a, $r);
                else {
                    $tempArray = array_map(function($e){ return (string) $e; }, iterator_to_array($a));
                    # CtoAmatches
                    $r[] = (object) [ "m" => $tempArray, "n" => $tempArray, "criterion" => (string) $c];
                }
            };
            return $r;
        };

        return $CtoCmatches($this->dm->criteria, $this->alternatives);
    }


}

?>