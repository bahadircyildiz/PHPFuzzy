<?php

namespace PHPFuzzy\Models;

/**
 * Class DecisionMaker
 * @package PHPFuzzy\Models
 */
class DecisionMaker extends Criterion {
    public $initialWeight = 1;

    /**
     * DecisionMaker constructor.
     * @param string $name
     * @param null $children
     * @param float|null $weight
     */
    function __construct(string $name, $children = null, float $weight = null){
        parent::__construct($name, $children, $weight);
        return $this;
    }
}

?>
