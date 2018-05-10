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
    public $weight;
    public $subcriteria;

    function __construct(string $name, CriterionList $subcriteria = null, float $weight = null){
        $this->name = $name;
        $this->weight = $weight;
        $this->subcriteria = $subcriteria ?? new CriterionList();
        return $this;
    }

    function __toString(){
        return "Criterion ".$this->name." #".Utils::getObjectID($this);
    }

    public function addSubcriterion(Criterion $sc){
        $this->subcriteria->add($sc);
    }
}

?>