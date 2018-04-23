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
        $this->checkSubcriteriaConsistency($subcriteria);
        return $this;
    }

    public function __toString(){
        return $this->name;
    }

    private function checkSubcriteriaConsistency($subcriteria){
        $totalWeight = 0;
        foreach ($subcriteria as $index => $sc) {
            $totalWeight += $sc->weight;
        }
        if($totalWeight != 1){
            die("Error adding the total weights of Criterion {$this->name}, expected 1, result {$totalWeight}");
        }
        $this->subcriteria = $subcriteria;
    }
}

?>