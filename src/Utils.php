<?php

namespace PHPFuzzy;
use PHPFuzzy\Models\Alternative;

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

    public static function iteratorToArray(&$iterator){
        $r = [];
        foreach ($iterator as &$i) {
            $r[] = $i;
        }
        return $r;
    }

    public static function collectClusters($dm, $aL){
        $totalClusters = [];
        $collectClustersRecursive = function($cluster) use(&$totalClusters, &$collectClustersRecursive){
            $totalClusters[] = $cluster;
            foreach ($cluster as $c_i => $c) {
                if(count($c->children) > 0) $collectClustersRecursive($c->children);
            }
        };
        $collectClustersRecursive([$dm]);
        $totalClusters[] = $aL;
        return $totalClusters;
    }

    public static function listPCMCombinations($dm, $aL, $type, $count = 1){
        $pcml = [];
        if($type = "H"){
            self::objectArrayWalkRecursive(function(&$e, $indexArr) use (&$pcml, $aL){
                if(!($e instanceof Alternative)){
                    if(count($e->children) != 0){
                        $children = self::objectCollectAttrRecursive($e->children, "name");
                        $pcml[] = ["pairs" => $children, "comparedWith" => $e->name];
                    } else{
                        $aL = self::objectCollectAttrRecursive($aL, "name");
                        $pcml[] = ["pairs" => $aL, "comparedWith" => $e->name];
                    }
                }  
            }, [$dm], "children");
            return $pcml;
        } else if ($type = "N"){
            $clusters = self::collectClusters($dm, $aL);
            $flattenedClusters = [];
            $arrWalkRec = function($e) use($flattenedClusters, &$arrWalkRec){
                if(is_iterable($e)){
                    foreach ($e as $value) {
                        $arrWalkRec($e);
                    }
                } else {
                    $flattenedClusters[] = $e->name;
                }
            };
            return array_map(function($e){
                    return ["pairs" => array_rand($clusters, 1)[0], 
                            "comparedWith" => array_rand(array_rand($clusters, 1)[0], 0) ];
            }, range(0, $count));

        }
    }
    
    public static function getRoadMapsToAlternative($altIndex, $dm){
        $roadMaps = [];
        self::objectArrayWalkRecursive(function(&$e, $indexArr) use (&$roadMaps, $altIndex){
            if($e instanceof Alternative) if($indexArr[count($indexArr)-1] == $altIndex){
                $roadMaps[] = $indexArr;
            }
        }, $dm->children, "children");
        return $roadMaps;
    }

    public static function objectArrayWalkRecursive($callback, $objList, $recursiveAttr = null, $indexArr = []){
        foreach($objList as $o_i => &$o){
            $index = array_merge($indexArr, [$o_i]);
            $callback($o, $index);
            if($recursiveAttr != null) if(isset($o->{$recursiveAttr})){
                self::objectArrayWalkRecursive($callback, $o->{$recursiveAttr}, $recursiveAttr, $index);
            }
        }
    }

    public static function normalize(array $arr){
        $total = array_sum($arr);
        return array_map(function($e) use ($total){ 
            return $total == 0 ? 0 : round($e / $total, 4);
        }, $arr);
    }
}

?>