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
    protected $weight;
    public $subcriteria;

    function __construct(string $name, CriterionList $subcriteria = null, float $weight = null){
        $this->name = $name;
        $this->weight = $weight;
        $this->subcriteria = $subcriteria ?? new CriterionList();
        return $this;
    }

    function __toString(){
        return "Criterion ".$this->name." #";
    }

    public function setWeight($weight){
        $this->weight = $weight;    
    }

    public function addSubcriterion(Criterion $sc){
        $this->subcriteria->add($sc);
    }
}

?>