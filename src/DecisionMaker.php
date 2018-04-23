<?php


class DecisionMaker {

    public $name;
    public $criteria = [];

    public function __construct($name, $criteria){
        $this->name = $name;
        $this->checkCriteriaConsistency($criteria);
        return $this;
    }

    public function __toString(){
        return $this->name;
    }

    private function checkCriteriaConsistency($criteria){
        $totalWeight = 0;
        foreach ($criteria as $index => $sc) {
            $totalWeight += $sc->weight;
        }
        if($totalWeight != 1){
            die("Error adding the total weights in DecisionMaker {$this->name}, expected 1, result {$totalWeight}.");
        }
        $this->criteria = $criteria;
    }
}

?>
