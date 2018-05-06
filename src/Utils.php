<?php

namespace Bahadircyildiz\PHPFuzzy;

class Utils{

    private static function powerSet($in,$minLength = 1) { 
        $count = count($in); 
        $members = pow(2,$count); 
        $return = array(); 
        for ($i = 0; $i < $members; $i++) { 
           $b = sprintf("%0".$count."b",$i); 
           $out = array(); 
           for ($j = 0; $j < $count; $j++) { 
              if ($b{$j} == '1') $out[] = $in[$j]; 
           } 
           if (count($out) >= $minLength) { 
              $return[] = $out; 
           } 
        } 
        return $return; 
    }

    public function getSubsets($arrayset, $elemCount){
        $return = self::powerSet($arrayset,$elemCount);
        return array_filter($return, function($elem) use ($elemCount){ 
            return count($elem) == $elemCount; 
        });
    }

    public function objectCollectAttrRecursive($array, $attrName, $recursiveArrayAttr = null){
        $return = [];
        $method = __METHOD__;
        foreach ($array as $a_index => $a_) {
            $return[] = $a_->{$attrName};
            if ($recursiveArrayAttr != null) if(count($a_->{$recursiveArrayAttr}) > 0)
                $return += $method($a_->{$recursiveArrayAttr}, $attrName, $recursiveArrayAttr);
        }
        return $return;
    }

    public function objectCheckSameAttrRecursive($objArr, $attrName, $recursiveArrayName = null, &$valArray = []){
        $return = false;
        $method = __METHOD__;
        foreach ($array as $a_index => $a_) {
            if(in_array($valArray, $a_->{$attrName}))
                return true;
            else
                $valArray[] = $a_->{$attrName};
            if ($recursiveArrayAttr != null) if(count($a_->{$recursiveArrayAttr}) > 0)
                $return = $return || $method($a_->{$recursiveArrayAttr}, $attrName, $valArray);
        }
        return $return; 
    }

    public function validateArrayAsCollection(array $arr, $class){
        foreach ($arr as $a_) {
            if(!($a_ instanceof $class))
                die("Error: in validating member of {$class}");
        }
        return true;
    }
}

?>