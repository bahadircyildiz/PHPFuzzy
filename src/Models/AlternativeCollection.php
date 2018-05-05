<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
use Bahadircyildiz\PHPFuzzy\Utils;


class AlternativeCollection extends Collection{
    
    private $items = [];

    function __construct(array $items){
        $this->validateAlternativeArray($items);
    }

    function  add(Alternative $alternative){
        $this->validateAlternativeName($alternative);
    }

    function validateAlternativeName(Alternative $alternative){
        foreach ($this->items as $i_) {
            if($i_->name == $alternative->name)
                die("Error: Same name spotted while adding {$alternative->name} to the Alternatve List");
        }
        $this->items[] = $alternative;   
    }

    function validateAlternativeArray(array $array){
        $result = Utils::objectCheckSameAttrRecursive($array, "name");
        if($result)
            die("Error: Same name spotted while checking Alternatve List");
    }



}
?>