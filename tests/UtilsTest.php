<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
use Bahadircyildiz\PHPFuzzy\Models\{FuzzyNumber as §, DecisionMaker, Criterion, Alternative, FuzzyMatrix};
use Bahadircyildiz\PHPFuzzy\{ FuzzyMCDM, Utils };
use PHPUnit\Framework\TestCase;

class FuzzyOperationsTest extends TestCase{

    public function testValidateArrayAsCollection(){
        $sample = new FuzzyNumber([2,3,5]);
        $expected = true; 
        $result = Utils::validateArrayAsCollection($sample, FuzzyNumber);
        $this->assertEquals($expected, $result);
    }
  
}