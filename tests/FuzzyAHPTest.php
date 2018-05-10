<?php 

use PHPFuzzy\Models\{FuzzyNumber as §, DecisionMaker, Criterion, CriterionList, Alternative, AlternativeList};
use PHPFuzzy\{ FuzzyMCDM, Utils };
use PHPUnit\Framework\TestCase;

class FuzzyAHPTest extends TestCase{
    public function testDefineDecisionMaker(){
        $subcriteria1 = new CriterionList([
            new Criterion("SubCriteria 1"),
            new Criterion("SubCriteria 2"),
            new Criterion("SubCriteria 3")
        ]);
        $subcriteria2 = new CriterionList([
            new Criterion("SubCriteria 4"),
            new Criterion("SubCriteria 5"),
            new Criterion("SubCriteria 6"),
            new Criterion("SubCriteria 7")
        ]);
        $criteria = new CriterionList([
            new Criterion("Criteria 1", $subcriteria1),
            new Criterion("Criteria 2", $subcriteria2)
        ]);
        $alts = new AlternativeList([
            new Alternative("Kia"),
            new Alternative("Nissan"),
            new Alternative("Alfa Romeo")        
        ]);
        $dm = new DecisionMaker("Decision Maker 1", $criteria);
        // $this->assertEquals($expected->getMatrix(), $a->getMatrix());
    }

    
}