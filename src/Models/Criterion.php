<?php

    /**Example Criteria Scheme
     * $DecisionMaker = [ 
     *  new Criterion("Cost", 0.25, [
     *      new Criterion("Taxes", 0.30),
     *      new Criterion("Expenses", 0.70)
     *  ]),
     *  new Criterion("Durability", 0.75)
     * ]
     */
namespace PHPFuzzy\Models;
use PHPFuzzy\{ Utils };

class Criterion {

    public $name;
    protected $weight = [];
    public $children;
    protected $rank = [];

    function __construct(string $name, $children = null, float $weight = null){
        $this->name = $name;
        $this->weight = $weight;
        $this->children = $children;
        return $this;
    }

    function __toString(){
        return __CLASS__.": ".$this->name." #";
    }

    public function getWeight($type){
        return $this->weight[$type];
    }

    public function setWeight($type, $weight){
        // var_export($weight);
        $this->weight[$type] = $weight;    
    }

    public function getRank($type){
        return $this->rank[$type];
    }

    public function setRank($type, $rank){
        $this->rank[$type] = $rank;
    }

    public function setChildren($children){
        $this->children = $children;
    }

    function getNodeByRoadMap($arr){
        // var_export($arr);
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