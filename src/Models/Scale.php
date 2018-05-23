<?php

namespace PHPFuzzy\Models;

class Scale {

    public $tag;
    public $value;
    public $definition;
    
    function __construct(string $tag, FuzzyNumber $value, $definition = null){
        $this->tag = $tag;
        $this->value = $value;
        $this->definition = $definition;
    }
}
?>