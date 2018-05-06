<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class DecisionMaker {

    public $name;
    public $criteria = [];

    function __construct(string $name, CriterionList $criteria){
        $this->name = $name;
        $this->criteria = $criteria;
    }

    function __toString(){
        return $this->name;
    }
}

?>
