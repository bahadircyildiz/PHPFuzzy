<?php

namespace PHPFuzzy\Models;
use PHPFuzzy\{ Utils };

class Alternative {

    public $name;
    public $stats = [];
    protected $weight = [];

    function __construct(string $name, array $stats = null){
        $this->name = $name;
        $this->stats = $stats;
    }
    
    function __toString(){
        return "Alternative ".$this->name." #";
    }

    public function setWeight($type, $weight){
        $this->weight[$type] = $weight;
    }

    public function getWeight($type){
        return $this->weight[$type];
    }
}

?>