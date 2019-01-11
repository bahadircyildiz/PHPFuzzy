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

/**
 * Class Node
 * @package PHPFuzzy\Models
 */
class Node {

    public $name;
    protected $weight;
    protected $rank = [];

    /**
     * Node constructor.
     * @param string $name
     * @param null $children
     * @param array $weight
     */
    function __construct(string $name, $children = null, $weight = [ "local" => [], "global" => [] ]){
        $this->name = $name;
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string
     */
    function __toString(){
        return __CLASS__.": ".$this->name." #";
    }

    /**
     * @param $type
     * @param null $nodeName
     * @return mixed
     */
    public function getWeight($type, $nodeName =  null){
        return $nodeName === null ? $this->weight[$type] : $this->weight[$type][$nodeName];
    }

    /**
     * @param $type
     * @param $nodeName
     * @param null $weight
     */
    public function setWeight($type, $nodeName, $weight = null){
        if(is_array($nodeName)) $this->weight[$type] = $nodeName;
        else $this->weight[$type][$nodeName] = $weight;    
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getRank($type){
        return $this->rank[$type];
    }

    /**
     * @param $type
     * @param $rank
     */
    public function setRank($type, $rank){
        $this->rank[$type] = $rank;
    }
}
