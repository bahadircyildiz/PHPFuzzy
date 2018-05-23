<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ Utils };

class Criterion extends Node{

    public $children;

    function __construct(string $name, $children = null, float $weight = null){
        parent::__construct($name, $weight = null);
        $this->children = $children;
        return $this;
    }

    public function setChildren($children){
        $this->children = $children;
    }

    function getNodeByName(string $name){
        if($this->name == $name) return $this;
        else {
            $return = null;
            if(isset($this->children)) foreach ($this->children as $child) {
                // $return[] = $child->getNodeByName($name);
                $result = $child->getNodeByName($name);
                if($result != null ){
                    $return = $result;
                    break;
                }
            }
            return $return;
        }
        return null;
    }

    function getNodeByRoadMap($arr){
        if(count($arr) == 1){
            return $this;
        } else {
            array_shift($arr);
            $ret = $this;
            foreach ($arr as $index) {
                $ret = $ret->children->get($index);
            }
            return $ret;
        }
    }
}

?>