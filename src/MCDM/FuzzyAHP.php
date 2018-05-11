<?php
namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{   FuzzyNumber, DecisionMaker, AlternativeList, PairwiseComparisonMatrixList as PCML, 
                        PairwiseComparisonMatrix as PCM};
use PHPFuzzy\{ Utils , FuzzyOperations as §§};


class FuzzyAHP{
    protected $dm;
    protected $alternatives;
    /**
     * Pairwise Comparison Matrix List
     */
    protected $pcml;
    protected $S;

    function __construct(DecisionMaker $dm, AlternativeList $alternatives, PCML $pcml = null){
        $this->dm = $dm;
        $this->alternatives = $alternatives;
        $this->pcml = $pcml ?? new PCML();
    }

    public function start(){
        $this->validateInputs();
    }

    private function validateInputs(){
        $remaining = $this->getRemainingCombinations();
        if(count($remaining) > 0){
            $arrStr = implode(",", array_map(function($e){ return serialize($e);}));
            die("Remaining Pairwise Comparison Matrix combinations: {$arrStr}");
        }
    }

    public function listPCMCombinations(){
        $CtoCmatches = function($cL, $a, &$r = []) use (&$CtoCmatches){
            $tempArray = array_map(function($e){ return (string) $e; }, iterator_to_array($cL));
            $r[] = [ "m" => $tempArray, "n" => $tempArray ];
            foreach ($cL as $c) {
                if(count($c->subcriteria) > 0)
                    $CtoCmatches($c->subcriteria, $a, $r);
                else {
                    $tempArray = array_map(function($e){ return (string) $e; }, iterator_to_array($a));
                    # CtoAmatches
                    $r[] = [ "m" => $tempArray, "n" => $tempArray, "criterion" => (string) $c];
                }
            };
            return $r;
        };

        return $CtoCmatches($this->dm->criteria, $this->alternatives);
    }

    public function getPCML(){
        return $this->pcml;
    }

    public function getRemainingCombinations(){
        $existing = $this->pcml->getCombinationsInList();
        $required = $this->listPCMCombinations();
        return array_diff($required, $existing);
    }

    public function RS(int $rowIndex, PCM $pcm){
        $A = $pcm->getMatrix();
        $total = new FuzzyNumber([0,0,0]);
        foreach ($A[$rowIndex] as $n => $cell) {
            $total = §§::sum($total, $cell);
        }
        return $total;
    }

    public function S_correct(int $rowIndex, PCM $pcm){
        $RSall = new FuzzyNumber([0,0,0]);
        $A = $pcm->getMatrix();
        foreach($A as $m => $mVal){
            $RSall = $m == $rowIndex ?
                §§::subtract($RSall, $this->RS($m, $pcm)) :
                §§::sum($RSall, $this->RS($m, $pcm)); 
        }
        return §§::divide($this->RS($rowIndex, $pcm), $RSall);
    }

    public static function V(FuzzyNumber $s1, FuzzyNumber $s2){
        if($s1->m() >= $s2->m())
            return 1;
        else if($s2->l() <= $s1->u())
            return  ($s1->u() - $s2->l()) 
                    / 
                    ( ($s1->u() - $s1->m() ) + ($s2->m() - $s2->l() ) );  
        else return 0;
    }

    public function w(PCM $pcm){
        $S = [];
        foreach ($pcm->getMatrix() as $index => $value){
            $S[$index] = $this->S_correct($index, $pcm);
        }
        $V = array_fill(0, $pcm->getM(), []);
        for ($i=0; $i < $pcm->getM(); $i++) { 
            for ($ii=0; $ii < $pcm->getM(); $ii++) { 
                $V[$i][$ii] = self::V( $S[$i], $S[$ii] );
            }
        }
        $w = array_map(function($e){ return min($e); }, $V);
        return Utils::vectorize($w);



    }



}

?>