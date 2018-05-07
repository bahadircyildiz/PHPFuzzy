<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
use Bahadircyildiz\PHPFuzzy\Models\{FuzzyNumber, DecisionMaker, Criterion, Alternative, FuzzyMatrix};
use Bahadircyildiz\PHPFuzzy\{ FuzzyMCDM, Utils };
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase{

    public function testValidateArrayAsCollection(){
        $sample = [
            new FuzzyNumber([2,3,5]),
            new FuzzyNumber([2,3,5]),
            new FuzzyNumber([2,3,5])
        ];
        $expected = true;
        $result = Utils::validateArrayAsCollection($sample, FuzzyNumber::class);
        $this->assertEquals($expected, $result);
    }
  
}