<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
use Bahadircyildiz\PHPFuzzy\{FuzzyNumber as §, 
    FuzzyOperations as §§, FuzzyMCDM, DecisionMaker, Criterion, Alternative};
use PHPUnit\Framework\TestCase;

class FuzzyOperationsTest extends TestCase{

    public function testPrintFuzzyNumberInt(){
        $a = new §(array(30,40,50));
        $expected = new §(array("0;30","1;40","0;50"));
        $this->assertEquals($expected, $a);
    }

    public function testPrintIfTriangular(){
        $a = new §(array(30,40,50));
        $this->assertEquals(true, $a->isTriangular());
        $this->assertEquals(false, $a->isTrapezoid());
    }

    public function testFuzzySumCheck() {
        $a = new §(array(30,40,50));
        $b = new §(array(20,40,60));
        $expected = new §(array(50,80,110));
        $this->assertEquals($expected, §§::sum($a,$b));
    }

    public function testFuzzySumWithDifferentLengthCheck() {
        $a = new §(array(30,40,50));
        $b = new §(array(20,40,60, 80));
        $expected = new §(array(50,80,100, 130));
        $this->assertEquals($expected, §§::sum($a,$b));
    }

    public function testFuzzySubtractCheck() {
        $a = new §(array(40,60,100));
        $b = new §(array(30,20,60));
        $expected = new §(array(100,80,130));
        $this->assertEquals($expected, §§::subtract($a,$b));
    }
    
    public function testFuzzyMultiplyCheck() {
        $a = new §(array(30,40,50));
        $b = new §(array(20,40,60));
        $expected = new §(array(600,1600,3000));
        $this->assertEquals($expected, §§::multiply($a,$b));
    }

    public function testFuzzyDivideCheck() {
        $a = new §(array(30,40,50));
        $b = new §(array(20,40,60));
        $expected = new §(array(1800,1600,1000));
        $this->assertEquals($expected, §§::divide($a,$b));
    }

    public function testFuzzyMembershipFunction(){
        $a = new §(array(30,40,100));
        $expected = 0.5;
        $this->assertEquals($expected, $a->µ(70));
    }

    public function testFuzzyDefuzzificate(){
        $a = new §([30,40,100]);
        $expected = 56.666666666655303;
        $this->assertEquals($expected, $a->defuzzificate('CoA'));
    }

    public function testFuzzySubsetCriterias(){
        $sampleDM = new DecisionMaker("Deneme Karar Verici", [
            new Criterion("Kriter 1", 0.75),
            new Criterion("Kriter 2", 0.15),
            new Criterion("Kriter 3", 0.10)
        ]);
        $sampleAlts = [ 
            new Alternative("Honda", [
                "Kriter 1"=> 6,
                "Kriter 2"=> 7
            ] ),
            new Alternative("KIA", [
                "Kriter 1"=> 8,
                "Kriter 2"=> 9
            ] )
        ];
        $AHPSess = FuzzyMCDM::AHP($sampleDM, $sampleAlts);
        $AHPSess->createPairwiseMatrices();

    }
  /**
  * Just check if the YourClass has no syntax error 
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  * 
  */
  // public function testIsThereAnySyntaxError(){
    // $var = new Buonzz\Template\YourClass;
    // $this->assertTrue(is_object($var));
    // unset($var);
  // }
  
  /**
  * Just check if the YourClass has no syntax error 
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  // public function testMethod1(){
    // $var = new Buonzz\Template\YourClass;
    // $this->assertTrue($var->method1("hey") == 'Hello World');
    // unset($var);
  // }
  
}