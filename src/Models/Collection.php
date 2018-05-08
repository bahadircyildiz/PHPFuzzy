<?php

namespace PHPFuzzy\Models;

class Collection implements \Countable, \IteratorAggregate{

    protected $items = [];

    function __construct($items){
        $this->items = $items;
    }

    function getIterator(){
        return new \ArrayIterator($this->items);
    }

    function count(){
        return count($this->items);
    }
}
?>