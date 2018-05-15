<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\Utils;
use MathPHP\Exception\BadDataException;

class AlternativeList extends Collection{

    function __construct(array $items){
        Utils::validateArrayAsCollection($items, Alternative::class);
        $this->validateAlternativeArray($items);
        $this->items = $items;
    }

    function  add(Alternative $alternative){
        $this->validateAlternativeName($alternative);
        $this->items[] = $alternative;
    }

    function validateAlternativeName(Alternative $alternative){
        foreach ($this->items as $i_) {
            if($i_->name == $alternative->name)
                throw new BadDataException("Error: Same name spotted while adding {$alternative->name} to the Alternatve List");
        }
        $this->items[] = $alternative;   
    }

    function validateAlternativeArray(array $array){
        $result = Utils::objectCheckSameAttrRecursive($array, "name");
        if($result)
            throw new BadDataException("Error: Same name spotted while checking Alternatve List");
    }



}
?>