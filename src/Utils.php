<?php

namespace PHPFuzzy;

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

    public static function getSubsets($arrayset, $elemCount){
        $return = self::powerSet($arrayset,$elemCount);
        return array_filter($return, function($elem) use ($elemCount){ 
            return count($elem) == $elemCount; 
        });
    }

    public static function objectCollectAttrRecursive($array, $attrName, $recursiveArrayAttr = null){
        $return = [];
        $method = __METHOD__;
        foreach ($array as $a_index => $a_) {
            $return[] = $a_->{$attrName};
            if ($recursiveArrayAttr != null) if(count($a_->{$recursiveArrayAttr}) > 0)
                $return += $method($a_->{$recursiveArrayAttr}, $attrName, $recursiveArrayAttr);
        }
        return $return;
    }

    public static function objectCheckSameAttrRecursive($objArr, $attrName, $recursiveArrayAttr = null, &$valArray = []){
        $return = false;
        $method = __METHOD__;
        foreach ($objArr as $a_index => $a_) {
            if(in_array($a_->{$attrName}, $valArray))
                return true;
            else
                $valArray[] = $a_->{$attrName};
            if ($recursiveArrayAttr != null) if(count($a_->{$recursiveArrayAttr}) > 0)
                $return = $return || $method($a_->{$recursiveArrayAttr}, $attrName, $valArray);
        }
        return $return; 
    }

    public static function validateArrayAsCollection(array $arr, $class){
        foreach ($arr as $a_) {
            if(!($a_ instanceof $class))
                throw new \Exception("Error: in validating member of {$class}");
        }
        return true;
    }

    public static function getObjectID(&$obj) {
        if(!is_object($obj))
            return false;
        ob_start();
        preg_match('~^.+?#(\d+)~s', ob_get_clean(), $oid);
        return $oid[1]; 
    }

    public static function vectorize(array $arr){
        $total = array_sum($arr);
        return array_map(function($e) use ($total){ 
            return $e / $total;
        }, $arr);
    }
}

?>