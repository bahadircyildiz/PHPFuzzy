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
namespace Bahadircyildiz\PHPFuzzy\Models;

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
        return $this->name;
    }
}

?>