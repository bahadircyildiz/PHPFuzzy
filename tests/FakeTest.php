<?php 

use PHPFuzzy\Models\{FuzzyNumber as §, DecisionMaker, Criterion, CriterionList, Alternative, AlternativeList};
use PHPFuzzy\{ FuzzyMCDM, Utils ,Fake};
use PHPUnit\Framework\TestCase;

class FakeTest extends TestCase{
    public function testFakeDecisionMaker(){
        $dm = Fake::DecisionMaker(1,3,2)[0];
        $alts = new AlternativeList(Fake::Alternative(3));
        $pcm = Fake::PairwiseComparisonMatrix($dm, $alts);
        var_dump($pcm);
    }

    
}