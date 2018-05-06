<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class DecisionMaker {

    public $name;
    public $criteria;

    function __construct(string $name, CriterionList $criteria = null){
        $this->name = $name;
        $this->criteria = $criteria ?? new CriterionList();
    }

    function __toString(){
        return $this->name;
    }
}

?>
