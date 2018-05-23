<?php

namespace PHPFuzzy\Models;

class DecisionMaker extends Criterion {
    public $initialWeight = 1;

    function __construct(string $name, $children = null, float $weight = null){
        parent::__construct($name, $children, $weight);
        return $this;
    }
}

?>
