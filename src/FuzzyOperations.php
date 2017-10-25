<?php 

namespace Bahadircyildiz\PHPFuzzy;

    /**
    *  A sample class
    *
    *  Use this section to define what this class is doing, the PHPDocumentator will use this
    *  to automatically generate an API documentation using this information.
    *
    *  @author Bahadir Can Yildiz
    */
class FuzzyOperations {

    /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
    
    /**
    * Sample method 
    *
    * Always create a corresponding docblock for each method, describing what it is for,
    * this helps the phpdocumentator to properly generator the documentation
    *
    * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
    *
    * @return string
    */

    public function lengthCheck(FuzzyNumber $a, FuzzyNumber $b){
        if($a->length != $b->length) die("Length of the fuzzy numbers are not equal");
    }

    public function sum(FuzzyNumber $a, FuzzyNumber $b){
        $this->lengthCheck($a, $b);
        $result = array();
        foreach ($a->value as $i => $v) {
            $result[] = $a->value[$i] + $b->value[$i];    
        }
        return new FuzzyNumber($result);
    }

    public function subtract(FuzzyNumber $a, FuzzyNumber $b){
        $b_reverse = new FuzzyNumber(array_reverse($b->value));
        return $this->sum($a, $b_reverse);
    }

    public function multiply(FuzzyNumber $a, FuzzyNumber $b){
        $this->lengthCheck($a, $b);
        $result = array();
        foreach ($a->value as $i => $v) {
            $result[] = $a->value[$i] * $b->value[$i];    
        }
        return new FuzzyNumber($result);
    }

    public function divide(FuzzyNumber $a, FuzzyNumber $b){
        $b_reverse = new FuzzyNumber(array_reverse($b->value));
        return $this->multiply($a, $b_reverse);
    }

    


}