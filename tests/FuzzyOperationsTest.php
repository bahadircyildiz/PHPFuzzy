<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
class FuzzyOperationsTest extends PHPUnit_Framework_TestCase{

  public function testFuzzySumCheck() {
    $a = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(30,40,50));
    $b = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(20,40,60));
    $fo = new \Bahadircyildiz\PHPFuzzy\FuzzyOperations();
    $expected = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(50,80,110));
    $this->assertEquals($expected, $fo->sum($a,$b));
  }

  public function testFuzzySubtractCheck() {
    $a = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(40,60,100));
    $b = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(30,20,60));
    $fo = new \Bahadircyildiz\PHPFuzzy\FuzzyOperations();
    $expected = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(100,80,130));
    $this->assertEquals($expected, $fo->subtract($a,$b));
  }

  public function testFuzzyMultiplyCheck() {
    $a = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(30,40,50));
    $b = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(20,40,60));
    $fo = new \Bahadircyildiz\PHPFuzzy\FuzzyOperations();
    $expected = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(600,1600,3000));
    $this->assertEquals($expected, $fo->multiply($a,$b));
  }

  public function testFuzzyDivideCheck() {
    $a = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(30,40,50));
    $b = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(20,40,60));
    $fo = new \Bahadircyildiz\PHPFuzzy\FuzzyOperations();
    $expected = new \Bahadircyildiz\PHPFuzzy\FuzzyNumber(array(1800,1600,1000));
    $this->assertEquals($expected, $fo->divide($a,$b));
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