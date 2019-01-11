<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;

/**
 * Class FuzzyNumberList
 * @package PHPFuzzy\Models
 */
class FuzzyNumberList extends Collection{

    /**
     * FuzzyNumberList constructor.
     * @param array $items
     * @throws \Exception
     */
    function __construct(array $items = []){
        Utils::validateArrayAsCollection($items, FuzzyNumber::class);
        parent::__construct($items);
    }

    /**
     * @param FuzzyNumber $fn
     */
    function add(FuzzyNumber $fn){
        $this->items[] = $fn;
    }

}
?>