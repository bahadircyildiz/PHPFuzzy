<?php

namespace PHPFuzzy\Models;

class DecisionMaker extends Criterion {
    function __construct(string $name, $children = null, float $weight = null){
        parent::__construct($name, $children, $weight);
        $this->weight = 1;
        return $this;
    }
}

?>
