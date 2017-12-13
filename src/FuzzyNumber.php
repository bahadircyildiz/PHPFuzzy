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
class FuzzyNumber {

    /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
    // private $m_SampleProperty = '';
    
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
    public $value;
    public $length;

    public function __construct($arr){
        $this->fixToStandart($arr);
        $this->value = $arr;
        $this->length = count($arr);     
    }

    public function isTriangular(){
        if($this->length == 3) {
            foreach ($this->value as $key => $value) {
                if($value->ux != $key%2) return false;
            }
        }
        return true;
    }
    public function isTrapezoid(){
        if($this->length == 4){
            foreach ($this->value as $key => $value) {
                if($key == 0 || $key == 3){
                    if($value->ux != 0) return false;
                }
                else if($key == 1 || $key == 2){
                    if($value->ux != 1) return false;
                }  
            }
        } else return false;
        return true;
    }
    private function fixToStandart(array &$arr){
        foreach ($arr as $key => &$value) {
            if(is_integer($value)){
                if(count($arr) == 3){
                    $value = $key%2 . ";" . $value; 
                } else if (count($arr) == 4){
                    if($key == 0 || $key == 3) $value = "0;" . $value;
                    else $value = "1;" . $value; 
                }
            }
            if(is_string($value)){
                $temp = explode(";", $value);
                if(count($temp) > 1)
                    $value = (object) array("ux" => $value[0], "x" => $value[1]);
            }
        }
    }

    /**
    * In following workarounds, Number has 3 main attributes 
    *
    * Core:         x | Ma(x) = 1
    * Support:      x | Ma(x) <= 0
    * Boundary:     x | 0 < Ma(x) < 1
    *
    * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
    *
    * @return string
    */

    // public function defuzzificate(){
        
    // }
}