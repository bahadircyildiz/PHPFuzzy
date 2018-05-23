<?php
namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{   FuzzyNumber, DecisionMaker, Alternative, AlternativeList, PairwiseComparisonMatrixList as PCML, 
                        PairwiseComparisonMatrix as PCM, CriterionList, Criterion};
use PHPFuzzy\{ Utils , FuzzyOperations as §§};
use MathPHP\Exception\BadDataException;
use DeepCopy\DeepCopy;

class FuzzyAHP{
    public $dm;
    protected $aL;
    /**
     * Pairwise Comparison Matrix List
     */
    protected $pcml;

    function __construct(DecisionMaker $dm, AlternativeList $aL, PCML $pcml = null){
        $this->dm = $dm;
        $this->aL = $aL;
        $this->pcml = $pcml ?? new PCML();
        $this->fillAltsAsChildren();
    }

    public function start(){
        $this->setAllWeightsByAHP();
        $ret = [];
        foreach($this->aL as $a_i =>$alt){
            $ret[] = ["W" => $this->alternativeWeight($a_i), "alternative" => $alt];
        }
        return $ret;
    }

    public function setAllWeightsByAHP(){
        foreach ($this->pcml as &$pcm) {
            $w_normalized = Utils::normalize(self::w($pcm));
            foreach ($w_normalized as $w_i => $w) {
                $targetNode = $this->dm->getNodeByRoadMap($pcm->getRoadMap())->children->get($w_i);
                $targetNode->setWeight("local", $w);
            }   
        }
        Utils::objectArrayWalkRecursive(function($e, $indexArr){
            $global = 1; $roadMap = $indexArr;
            for ($i=0; $i < count($roadMap); $i++) { 
                $sliced = array_slice($roadMap, 0, $i+1);
                $global *= $this->dm->getNodeByRoadMap($sliced)->getWeight("local");
            }
            $this->dm->getNodeByRoadMap($roadMap)->setWeight("global", $global);       

        }, [$this->dm], "children");
    }

    public function alternativeWeight($altIndex){
        $recursiveFunc = function($node, $currentIndex) use($altIndex, &$recursiveFunc){
            if($node instanceof Alternative) {
                if($currentIndex == $altIndex)
                    return $node->getWeight("local");
            }
            else{
                $total = 0;
                foreach ($node->children as $c_i => $childNode) {
                        $total += $node->getWeight("local") * $recursiveFunc($childNode, $c_i);
                }
                return $total;
            }
        };
        return $recursiveFunc($this->dm, 0);
    }

    public function fillAltsAsChildren(){
        Utils::objectArrayWalkRecursive(function(&$e, $indexArr){
            if(!($e instanceof Alternative)){
                $copier = new DeepCopy();
                if($e->children == null) $e->children = $copier->copy($this->aL);
            }  
        }, $this->dm->children, "children");
    }

    // private function validateInputs(){
    //     $remaining = $this->getRemainingCombinations();
    //     if(count($remaining) > 0){
    //         $arrStr = implode(",", array_map(function($e){ return serialize($e);}));
    //         throw new BadDataException("Remaining Pairwise Comparison Matrix combinations: {$arrStr}");
    //     }
    // }

    public function getPCML(){
        return $this->pcml;
    }

    // public function getRemainingCombinations(){
    //     $existing = $this->pcml->getAllCombinationsInList();
    //     $required = Utils::listPCMCombinations($this->dm, $this->aL);
    //     return array_diff($required, $existing);
    // }

    public static function RS(int $rowIndex, PCM $pcm){
        $A = $pcm->getMatrix();
        $total = new FuzzyNumber([0,0,0]);
        foreach ($A[$rowIndex] as $n => $cell) {
            $total = §§::sum($total, $cell);
        }
        return $total;
    }

    public static function S_correct(int $rowIndex, PCM $pcm){
        $RSall = new FuzzyNumber([0,0,0]);
        $A = $pcm->getMatrix();
        foreach($A as $m => $mVal){
            $RSall = $m == $rowIndex ?
                §§::subtract($RSall, self::RS($m, $pcm)) :
                §§::sum($RSall, self::RS($m, $pcm)); 
        }
        return §§::divide(self::RS($rowIndex, $pcm), $RSall);
    }

    public static function V(FuzzyNumber $s1, FuzzyNumber $s2){
        if($s1->m() >= $s2->m())
            return 1;
        else if($s2->l() <= $s1->u())
            return  ($s1->u() - $s2->l())
                    /
                    ( ($s1->u() - $s1->m() ) + ($s2array_fill->m() - $s2->l() ) );  
        else return 0;
    }

    public static function w(PCM $pcm){
        $S = [];
        foreach ($pcm->getMatrix() as $index => $value){
            $S[$index] = self::S_correct($index, $pcm);
        }
        $V = array_fill(0, $pcm->getM(), []);
        for ($i=0; $i < $pcm->getM(); $i++) { 
            for ($ii=0; $ii < $pcm->getM(); $ii++) { 
                $V[$i][$ii] = self::V( $S[$i], $S[$ii] );
            }
        }
        $w = array_map(function($e){ return min($e); }, $V);
        return $w;
    }



}

?>