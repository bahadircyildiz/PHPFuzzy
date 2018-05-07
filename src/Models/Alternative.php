<?php

namespace Bahadircyildiz\PHPFuzzy\Models;
class Alternative {

    public $name;
    public $stats = [];

    function __construct(string $name, array $stats = null){
        $this->name = $name;
        $this->stats = $stats;
    }
    
    function __toString(){
        return $this->name;
    }
}

?>