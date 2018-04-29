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
namespace Bahadircyildiz\PHPFuzzy;

class Criterion {

    public $name;
    public $weight;
    public $subcriteria = [];

    function __construct(string $name, float $weight, $subcriteria = []){
        $this->name = $name;
        $this->weight = $weight;
        $this->checkSubcriteriaConsistency($subcriteria);
        return $this;
    }

    function __toString(){
        return $this->name;
    }

    public function addCriterion(Criterion $criterion){
        $this->subcriteria[] = $criterion;
    }

    private function checkSubcriteriaConsistency($subcriteria){
        $totalWeight = 0;
        foreach ($subcriteria as $index => $sc) {
            if(get_class($sc) != "Bahadircyildiz\PHPFuzzy\Criterion")
                die("Error: In Criterion {$this->name}, criterion type not valid in index {$index}.\n");
            $totalWeight += $sc->weight;
        }
        if(count($subcriteria) != 0 && $totalWeight != 1){
            die("Error: Total weights of Criterion {$this->name}; expected 1, result {$totalWeight}.\n");
        }
        $this->subcriteria = $subcriteria;
    }
}

?>