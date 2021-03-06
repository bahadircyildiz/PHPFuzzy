<?php 

use PHPFuzzy\Models\{FuzzyNumber as §, DecisionMaker, Criterion, CriterionList, Alternative, AlternativeList,
                        PairwiseComparisonMatrixList as PCML, PairwiseComparisonMatrix as PCM};
use PHPFuzzy\{ FuzzyMCDM, Utils, Fake };
use PHPUnit\Framework\TestCase;

class FuzzyMAUTTest extends TestCase{
    public function testGetCriteriaRoadmaps(){
        $subH = new CriterionList([
            new Criterion("HM"),
            new Criterion("HSP"),
            new Criterion("HSV")
        ]);
        $subQM = new CriterionList([
            new Criterion("VM"),
            new Criterion("COM"),
            new Criterion("CAM"),
            new Criterion("TM")
        ]);
        $subQS = new CriterionList([
            new Criterion("BSP"),
            new Criterion("ST"),
            new Criterion("CP"),
            new Criterion("PS")
        ]);
        $criteria = new CriterionList([
            new Criterion("H", $subH),
            new Criterion("QM", $subQM),
            new Criterion("QS", $subQS)
        ]);
        $alts = new AlternativeList([
            new Alternative("D"),
            new Alternative("M"),
            new Alternative("A")        
        ]);
        $dm = new DecisionMaker("G", $criteria);
        // $pcml = new PCML(Fake::PairwiseComparisonMatrix($dm, $alts));
        // $MAUTSess = FuzzyMCDM::MAUT($dm, $alts, $pcml);
        // $MAUTSess->start();
        
        
    }
    
}