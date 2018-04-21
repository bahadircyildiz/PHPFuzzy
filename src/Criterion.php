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

class Criterion {

    public $name;
    public $weight;
    public $subcriteria = [];

    public function __construct($name, $weight, $subcriteria = null){
        $this->name = $name;
        $this->weight = $weight;
        $this->subcriteria = $subcriteria; 
        return $this;
    }
}

?>