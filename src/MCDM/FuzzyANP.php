<?php

namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{FuzzyNumber,
    DecisionMaker,
    Alternative,
    AlternativeList,
    PairwiseComparisonMatrixList as PCML,
    PairwiseComparisonMatrix as PCM,
    CriterionList,
    Criterion,
    LabeledMatrix,
    Collection};
use PHPFuzzy\{Utils, FuzzyOperations as §§};
use MathPHP\Exception\BadDataException;
use MathPHP\LinearAlgebra\MatrixFactory;
use DeepCopy\DeepCopy;

/**
 * Class FuzzyANP
 * $this->dm => DecisionMaker;
 * $this->children => Every Cluster
 * so in matrix, Decisionmaker and subcriterias should exist.
 * @package PHPFuzzy\MCDM
 *
 * @property DecisionMaker $dm
 */
class FuzzyANP
{
    public $dm;
    protected $aL;
    protected $pcml;
    protected $clusters;
    protected $superMatrix;

    /**
     * FuzzyANP constructor.
     * @param $dm
     * @param $clusters
     * @param $aL
     * @param $pcml
     */
    function __construct($dm, $clusters, $aL, $pcml)
    {
        $this->dm = $dm;
        $this->clusters = $clusters;
        $this->aL = $aL;
        $this->pcml = $pcml;
    }

    /**
     * @return array
     */
    function start()
    {
        $this->superMatrix = $this->createSuperMatrix();
        foreach ($this->pcml as $pcm) {
            $w_normalized = Utils::normalize(self::w($pcm));
            // $targetNode = $this->dm->getNodeByName($pcm->getComparedWith());
            $targetNode = null;
            // if($targetNode == null){
            //     $targetNode = array_filter(array_to_iterator($this->aL), function($e) use ($pcm){
            //         return $e->name == $pcm->getComparedWith();
            //     })[0];
            // }

            foreach ([[$this->dm], $this->clusters, $this->aL] as $key => $value) {
                Utils::objectArrayWalkRecursive(function ($e) use ($pcm, &$targetNode) {
                    $targetNode = $e->name == $pcm->getComparedWith() ? $e : $targetNode;
                }, $value, "children");
            }
            foreach ($w_normalized as $w_i => $w) {
                $targetNode->setWeight("local", $pcm->getPairs()[$w_i], $w);
            }
        }
        /**
         * Filling Weighted Matrix
         */
        foreach ([[$this->dm], $this->clusters, $this->aL] as $key => $value) {
            Utils::objectArrayWalkRecursive(function ($e, $indexArr) {
                $weights = $e->getWeight("local");
                foreach ($weights as $nodeName => $w) {
                    $this->superMatrix->setCellByLabelName($e->name, $nodeName, $w);
                }
            }, $value, "children");
        }

        /**Normalizing Columns */
        $this->superMatrix = $this->superMatrix->normalize();
        /** Limit */
        $limitedSuperMatrix = $this->superMatrix->limit();
        $aLw = array_map(function ($e) use ($limitedSuperMatrix) {
            return [
                "name" => $e->name,
                "weight" => $limitedSuperMatrix->getCellByLabelName($this->dm->name, $e->name)
            ];
        }, iterator_to_array($this->aL));
        return $aLw;


    }

    /**
     * @return LabeledMatrix
     * @throws BadDataException
     */
    private function createSuperMatrix()
    {
        $flattenedClusters = Utils::getANPSuperMatrixLabels($this->dm, $this->clusters, $this->aL);
        return new LabeledMatrix($flattenedClusters, $flattenedClusters);
    }

    /**
     * @param $totalClusters
     * @return array
     */
    public function calculateComparisonCalculations($totalClusters)
    {
        $pairwiseComparisonList = [];
        foreach ($totalClusters as $tc1_i => $tc1) {
            foreach ($tc1 as $cm_i => $clusterMember) {
                foreach ($totalClusters as $tc2_i => $tc2) {
                    $pc = $this->createPairwiseComparison($clusterMember, $tc2);
                    $pc !== null ? $pairwiseComparisonList[] = $pc : null;
                };
            }
        }
        return $pairwiseComparisonList;
    }

    /**
     * @param $member
     * @param $cluster
     * @return object|null
     */
    public function createPairwiseComparison($member, $cluster)
    {
        $result;
        if (count($cluster) == 1) {
            return null;
        }
        $cluster = iterator_to_array($cluster);
        $search = array_filter($cluster, function ($e) {
            return $member->name == $e->name;
        });
        if (count($search) > 0) {
            foreach ($search as $key => $value) {
                $search = (object)["index" => $key, "value" => $value];
            }
            array_splice($cluster, $search->index, $search->index);
            if (count($cluster) == 1) {
                return null;
            } else {
                return (object)["pairs" => $cluster, "comparedWith" => $member];
            }
        } else {
            return (object)["pairs" => $cluster, "comparedWith" => $member];
        }
    }

    /**
     * @param int $rowIndex
     * @param PCM $pcm
     * @return FuzzyNumber
     */
    public static function RS(int $rowIndex, PCM $pcm)
    {
        $A = $pcm->getMatrix();
        $total = new FuzzyNumber([0, 0, 0]);
        foreach ($A[$rowIndex] as $n => $cell) {
            $total = §§::sum($total, $cell);
        }
        return $total;
    }

    /**
     * @param int $rowIndex
     * @param PCM $pcm
     * @return FuzzyNumber
     */
    public static function S_correct(int $rowIndex, PCM $pcm)
    {
        $RSall = new FuzzyNumber([0, 0, 0]);
        $A = $pcm->getMatrix();
        foreach ($A as $m => $mVal) {
            $RSall = $m == $rowIndex ?
                §§::subtract($RSall, self::RS($m, $pcm)) :
                §§::sum($RSall, self::RS($m, $pcm));
        }
        return §§::divide(self::RS($rowIndex, $pcm), $RSall);
    }

    /**
     * @param FuzzyNumber $s1
     * @param FuzzyNumber $s2
     * @return float|int
     */
    public static function V(FuzzyNumber $s1, FuzzyNumber $s2)
    {
        if ($s1->m() >= $s2->m()) {
            return 1;
        } else {
            if ($s2->l() <= $s1->u()) {
                return round(($s1->u() - $s2->l())
                    /
                    (($s1->u() - $s1->m()) + ($s2->m() - $s2->l())), 4);
            } else {
                return 0;
            }
        }
    }

    /**
     * @param PCM $pcm
     * @return array
     */
    public static function w(PCM $pcm)
    {
        $S = [];
        foreach ($pcm->getMatrix() as $index => $value) {
            $S[$index] = self::S_correct($index, $pcm);
        }
        $V = array_fill(0, $pcm->getM(), []);
        for ($i = 0; $i < $pcm->getM(); $i++) {
            for ($ii = 0; $ii < $pcm->getM(); $ii++) {
                $V[$i][$ii] = self::V($S[$i], $S[$ii]);
            }
        }
        $w = array_map(function ($e) {
            return min($e);
        }, $V);
        return $w;
    }
}