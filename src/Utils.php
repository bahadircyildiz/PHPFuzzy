<?php

namespace PHPFuzzy;

use PHPFuzzy\Models\Alternative;

/**
 * Class Utils
 * @package PHPFuzzy
 */
class Utils
{

    /**
     * @param $in
     * @param int $minLength
     * @return array
     */
    private static function powerSet($in, $minLength = 1)
    {
        $count = count($in);
        $members = pow(2, $count);
        $return = array();
        for ($i = 0; $i < $members; $i++) {
            $b = sprintf("%0" . $count . "b", $i);
            $out = array();
            for ($j = 0; $j < $count; $j++) {
                if ($b{$j} == '1') {
                    $out[] = $in[$j];
                }
            }
            if (count($out) >= $minLength) {
                $return[] = $out;
            }
        }
        return $return;
    }

    /**
     * @param $arrayset
     * @param $elemCount
     * @return array
     */
    public static function getSubsets($arrayset, $elemCount)
    {
        $return = self::powerSet($arrayset, $elemCount);
        return array_filter($return, function ($elem) use ($elemCount) {
            return count($elem) == $elemCount;
        });
    }

    /**
     * @param $array
     * @param $attrName
     * @param null $recursiveArrayAttr
     * @return array
     */
    public static function objectCollectAttrRecursive($array, $attrName, $recursiveArrayAttr = null)
    {
        $return = [];
        $method = __METHOD__;
        foreach ($array as $a_index => $a_) {
            $return[] = $a_->{$attrName};
            if ($recursiveArrayAttr != null) {
                if (count($a_->{$recursiveArrayAttr}) > 0) {
                    $return += $method($a_->{$recursiveArrayAttr}, $attrName, $recursiveArrayAttr);
                }
            }
        }
        return $return;
    }

    /**
     * @param $objArr
     * @param $attrName
     * @param null $recursiveArrayAttr
     * @param array $valArray
     * @return bool
     */
    public static function objectCheckSameAttrRecursive($objArr, $attrName, $recursiveArrayAttr = null, &$valArray = [])
    {
        $return = false;
        $method = __METHOD__;
        foreach ($objArr as $a_index => $a_) {
            if (in_array($a_->{$attrName}, $valArray)) {
                return true;
            } else {
                $valArray[] = $a_->{$attrName};
            }
            if ($recursiveArrayAttr != null) {
                if (count($a_->{$recursiveArrayAttr}) > 0) {
                    $return = $return || $method($a_->{$recursiveArrayAttr}, $attrName, $valArray);
                }
            }
        }
        return $return;
    }

    /**
     * @param array $arr
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public static function validateArrayAsCollection(array $arr, $class)
    {
        foreach ($arr as $a_) {
            if (!($a_ instanceof $class)) {
                throw new \Exception("Error: in validating member of {$class}");
            }
        }
        return true;
    }

    /**
     * @param $iterator
     * @return array
     */
    public static function iteratorToArray(&$iterator)
    {
        $r = [];
        foreach ($iterator as &$i) {
            $r[] = $i;
        }
        return $r;
    }

    /**
     * @param $dm
     * @param $aL
     * @return array
     */
    public static function collectClusters($dm, $aL)
    {
        $totalClusters = [];
        $collectClustersRecursive = function ($cluster) use (&$totalClusters, &$collectClustersRecursive) {
            $totalClusters[] = $cluster;
            foreach ($cluster as $c_i => $c) {
                if (count($c->children) > 0) {
                    $collectClustersRecursive($c->children);
                }
            }
        };
        $collectClustersRecursive([$dm]);
        $totalClusters[] = $aL;
        return $totalClusters;
    }

    /**
     * @param $dm
     * @param $aL
     * @param $type
     * @param $clusters
     * @param int $count
     * @return array
     */
    public static function listPCMCombinations($dm, $aL, $type, $clusters, $count = 1)
    {
        $pcml = [];
        if ($type = "H") {
            self::objectArrayWalkRecursive(function (&$e, $indexArr) use (&$pcml, $aL) {
                if (!($e instanceof Alternative)) {
                    if (count($e->children) != 0) {
                        $children = self::objectCollectAttrRecursive($e->children, "name");
                        $pcml[] = ["pairs" => $children, "comparedWith" => $e->name];
                    } else {
                        $aL = self::objectCollectAttrRecursive($aL, "name");
                        $pcml[] = ["pairs" => $aL, "comparedWith" => $e->name];
                    }
                }
            }, [$dm], "children");
            return $pcml;
        } else {
            if ($type = "N") {
                $clusters = array_merge($dm, $aL, $clusters);
                $flattenedClusters = Utils::getANPSuperMatrixLabels($dm, $clusters, $aL);
                return array_map(function ($e) use ($clusters, $flattenedClusters) {
                    return [
                        "pairs" => $clusters[array_rand($clusters, 1)[0]],
                        "comparedWith" => $flattenedClusters[array_rand($flattenedClusters, 0)]
                    ];
                }, range(0, $count));

            }
        }
    }

    /**
     * @param $dm
     * @param $clusters
     * @param $aL
     * @return array
     */
    public static function getANPSuperMatrixLabels($dm, $clusters, $aL)
    {
        $flattenedClusters = [];
        foreach ([[$dm], $clusters, $aL] as $value) {
            Utils::objectArrayWalkRecursive(function ($e) use (&$flattenedClusters) {
                if (!isset($e->children) || count($e->children) == 0) {
                    $flattenedClusters[] = $e->name;
                }
            }, $value, "children");
        }
        return $flattenedClusters;
    }

    /**
     * @param $altIndex
     * @param $dm
     * @return array
     */
    public static function getRoadMapsToAlternative($altIndex, $dm)
    {
        $roadMaps = [];
        self::objectArrayWalkRecursive(function (&$e, $indexArr) use (&$roadMaps, $altIndex) {
            if ($e instanceof Alternative) {
                if ($indexArr[count($indexArr) - 1] == $altIndex) {
                    $roadMaps[] = $indexArr;
                }
            }
        }, $dm->children, "children");
        return $roadMaps;
    }

    /**
     * @param $callback
     * @param $objList
     * @param null $recursiveAttr
     * @param array $indexArr
     */
    public static function objectArrayWalkRecursive($callback, $objList, $recursiveAttr = null, $indexArr = [])
    {
        foreach ($objList as $o_i => &$o) {
            $index = array_merge($indexArr, [$o_i]);
            $callback($o, $index);
            if ($recursiveAttr != null) {
                if (isset($o->{$recursiveAttr})) {
                    self::objectArrayWalkRecursive($callback, $o->{$recursiveAttr}, $recursiveAttr, $index);
                }
            }
        }
    }

    /**
     * @param array $arr
     * @return array
     */
    public static function normalize(array $arr)
    {
        $total = array_sum($arr);
        return array_map(function ($e) use ($total) {
            return $total == 0 ? 0 : round($e / $total, 4);
        }, $arr);
    }
}