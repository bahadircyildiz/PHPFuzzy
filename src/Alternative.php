<?php

namespace Bahadircyildiz\PHPFuzzy;
class Alternative {

    public $name;
    public $stats = [];

    function __construct(string $name,array $stats){
        $this->name = $name;
        $this->stats = $stats;
    }

    function __toString(){
        return $this->name;
    }
}

?>