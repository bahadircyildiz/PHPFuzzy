<?php

namespace PHPFuzzy\Models;

class DecisionMaker {

    public $name;
    public $criteria;

    function __construct(string $name, CriterionList $criteria){
        $this->criteria = $criteria;
        $this->name = $name;
    }

    function __toString(){
        return "DecisionMaker ".$this->name;
    }



    
}

?>
