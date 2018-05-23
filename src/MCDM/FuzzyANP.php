<?php
namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{   FuzzyNumber, DecisionMaker, Alternative, AlternativeList, PairwiseComparisonMatrixList as PCML, 
                        PairwiseComparisonMatrix as PCM, CriterionList, Criterion, LabeledMatrix, Collection};
use PHPFuzzy\{ Utils , FuzzyOperations as §§};
use MathPHP\Exception\BadDataException;
use MathPHP\LinearAlgebra\MatrixFactory;
use DeepCopy\DeepCopy;

class FuzzyANP{
    public $dm;
    protected $aL;
    protected $pcml;
    protected $superMatrix;

    function __construct($dm, $aL, $pcml){
        $this->dm = $dm;
        $this->aL = $aL;        
        $this->pcml = $pcml;
    }

    function start(){

        /**
         * $this->dm => DecisionMaker;
         * $this->children => Every Cluster
         * so in matrix, Decisionmaker and subcriterias should exist.
         */
        $this->superMatrix = $this->createSuperMatrix();
        foreach ($this->pcml as $pcm) {
            $w_normalized = Utils::normalize(self::w($pcm));
            $targetNode = $this->dm->getNodeByName($pcm->getComparedWith());
            if($targetNode == null){
                $targetNode = array_filter(array_to_iterator($this->aL), function($e) use ($pcm){
                    return $e->name == $pcm->getComparedWith();
                })[0];
            }
            foreach ($w_normalized as $w_i => $w) {
                $targetNode->setWeight("local", $pcm->getPairs()[$w_i], $w);
            }   
        }
        /**
         * Filling Weighted Matrix
         */
        Utils::objectArrayWalkRecursive(function($e, $indexArr){
            $weights = $e->getWeight("local");
            foreach ($weights as $nodeName => $w) {
                $this->superMatrix->setCellByLabelName($e->name, $nodeName, $w);
            }
        }, [$this->dm], "children");

        Utils::objectArrayWalkRecursive(function($e){
            $weights = $e->getWeight("local");
            foreach ($weights as $nodeName => $w) {
                $this->superMatrix->setCellByLabelName($e->name, $nodeName, $w);
            }
        }, $this->aL, "children");

        var_export($this->superMatrix);
        /**Normalizing Columns */
        $this->superMatrix = $this->superMatrix->normalize();
        /** Limit */
        $limitedSuperMatrix = $this->superMatrix->limit();
        echo (string) $limitedSuperMatrix;
        $aLw = array_map(function($e) use ($limitedSuperMatrix){
            return ["name" => $e->name, 
                    "weight" => $limitedSuperMatrix->getCellByLabelName($this->dm->name, $e->name)
                    ];
        },iterator_to_array($this->aL));
        return $aLw;
        

    }

    private function createSuperMatrix(){
        $flattenedClusters = [];

        foreach ([[$this->dm], $this->aL] as $value) {
            Utils::objectArrayWalkRecursive(function($e) use (&$flattenedClusters){
                $flattenedClusters[] = $e->name;
            },$value, "children");
        }

        return new LabeledMatrix($flattenedClusters, $flattenedClusters);    
    }

    public function calculateComparisonCalculations($totalClusters){
        $pairwiseComparisonList = [];
        foreach ($totalClusters as $tc1_i => $tc1) {
            foreach($tc1 as $cm_i => $clusterMember){
                foreach($totalClusters as $tc2_i => $tc2){
                    $pc = $this->createPairwiseComparison($clusterMember, $tc2);
                    $pc !== null ? $pairwiseComparisonList[] = $pc : null;  
                };
            }
        }
        return $pairwiseComparisonList;
    }

    public function createPairwiseComparison($member, $cluster){ 
        $result;
        if(count($cluster) == 1) return null;
        $cluster = iterator_to_array($cluster);
        $search = array_filter($cluster, function($e){
            return $member->name == $e->name;
        });
        if(count($search) > 0){
            foreach ($search as $key => $value) {
                $search = (object)["index" => $key, "value" => $value];
            }
            array_splice($cluster, $search->index, $search->index);
            if(count($cluster) == 1) return null;
            else return (object)["pairs" => $cluster, "comparedWith" => $member ];
        } else{
            return (object)["pairs" => $cluster, "comparedWith" => $member ];
        }
    }

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
            return round(   ($s1->u() - $s2->l()) 
                            / 
                            ( ($s1->u() - $s1->m() ) + ($s2->m() - $s2->l() ) ) , 4);  
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