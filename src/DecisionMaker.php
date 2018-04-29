<?php

namespace Bahadircyildiz\PHPFuzzy;

class DecisionMaker {

    public $name;
    public $criteria = [];

    function __construct(string $name, array $criteria){
        $this->name = $name;
        $this->checkCriteriaConsistency($criteria);
        return $this;
    }

    function __toString(){
        return $this->name;
    }

    public function addCriterion(Criterion $criterion){
        $this->criteria[] = $criterion;
    }

    private function checkCriteriaConsistency($criteria){
        $totalWeight = 0;
        foreach ($criteria as $index => $c) {
            if(get_class($c) != "Bahadircyildiz\PHPFuzzy\Criterion")
                die("Error: In DecisionMaker {$this->name}, criterion type not valid in index {$index}.\n");
            $totalWeight += $c->weight;
        }
        if($totalWeight != 1){
            die("Error: Total weights in DecisionMaker {$this->name}; expected 1, result {$totalWeight}.\n");
        }
        $this->criteria = $criteria;
    }
}

?>
