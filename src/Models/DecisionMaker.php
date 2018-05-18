<?php

namespace PHPFuzzy\Models;

class DecisionMaker extends Criterion {
    function __construct(string $name, $children = null, float $weight = null){
        parent::__construct($name, $children, $weight);
        $this->weight = ["local" => 1, "global" => 1];
        return $this;
    }
}

?>
