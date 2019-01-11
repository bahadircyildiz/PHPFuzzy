<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;
use MathPHP\Exception\BadDataException;

/**
 * Class AlternativeList
 * @package PHPFuzzy\Models
 */
class AlternativeList extends Collection{

    /**
     * AlternativeList constructor.
     * @param array $items
     * @throws BadDataException
     */
    function __construct(array $items){
        Utils::validateArrayAsCollection($items, Alternative::class);
        $this->validateAlternativeArray($items);
        $this->items = $items;
    }

    /**
     * @param Alternative $alternative
     * @throws BadDataException
     */
    function  add(Alternative $alternative){
        $this->validateAlternativeName($alternative);
        $this->items[] = $alternative;
    }

    /**
     * @param Alternative $alternative
     * @throws BadDataException
     */
    function validateAlternativeName(Alternative $alternative){
        foreach ($this->items as $i_) {
            if($i_->name == $alternative->name)
                throw new BadDataException("Error: Same name spotted while adding {$alternative->name} to the Alternatve List");
        }
        $this->items[] = $alternative;   
    }

    /**
     * @param array $array
     * @throws BadDataException
     */
    function validateAlternativeArray(array $array){
        $result = Utils::objectCheckSameAttrRecursive($array, "name");
        if($result)
            throw new BadDataException("Error: Same name spotted while checking Alternatve List");
    }



}
?>