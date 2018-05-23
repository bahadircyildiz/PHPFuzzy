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

    function get($index = null){
        return $index !== null ? $this->items[$index] : $this->items;
    }

    function getRandom(){
        $index = array_rand($this->items, 1);
        return $this->items[$index];
    }
}
?>