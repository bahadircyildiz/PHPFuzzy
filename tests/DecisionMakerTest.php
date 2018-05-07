<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
use Bahadircyildiz\PHPFuzzy\Models\{FuzzyNumber as §, DecisionMaker, Criterion, CriterionList, Alternative, AlternativeList};
use Bahadircyildiz\PHPFuzzy\{ FuzzyMCDM, Utils };
use PHPUnit\Framework\TestCase;

class DecisionMakerTest extends TestCase{
    public function testDefineDecisionMaker(){
        $subcriteria1 = new CriterionList([
            new Criterion("SubKriter 1"),
            new Criterion("SubKriter 2"),
            new Criterion("SubKriter 3")
        ]);
        $subcriteria2 = new CriterionList([
            new Criterion("SubKriter 4"),
            new Criterion("SubKriter 5"),
            new Criterion("SubKriter 6"),
            new Criterion("SubKriter 7")
        ]);
        $criteria = new CriterionList([
            new Criterion("Kriter 1", $subcriteria1),
            new Criterion("Kriter 2", $subcriteria2)
        ]);
        $alts = new AlternativeList([
            new Alternative("Kia"),
            new Alternative("Nissan"),
            new Alternative("Alfa Romeo")        
        ]);
        $a = new DecisionMaker("Karar verici 1", $criteria, $alts);

        d($a->listPCMCombinations());
        // $this->assertEquals($expected->getMatrix(), $a->getMatrix());
    }

    
}