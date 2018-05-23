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

class Node {

    public $name;
    protected $weight;
    protected $rank = [];

    function __construct(string $name, $children = null, $weight = [ "local" => [], "global" => [] ]){
        $this->name = $name;
        $this->weight = $weight;
        return $this;
    }

    function __toString(){
        return __CLASS__.": ".$this->name." #";
    }

    public function getWeight($type, $nodeName =  null){
        return $nodeName === null ? $this->weight[$type] : $this->weight[$type][$nodeName];
    }

    public function setWeight($type, $nodeName, $weight = null){
        if(is_array($nodeName)) $this->weight[$type] = $nodeName;
        else $this->weight[$type][$nodeName] = $weight;    
    }

    public function getRank($type){
        return $this->rank[$type];
    }

    public function setRank($type, $rank){
        $this->rank[$type] = $rank;
    }
}

?>