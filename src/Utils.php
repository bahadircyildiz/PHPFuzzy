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
}

?>