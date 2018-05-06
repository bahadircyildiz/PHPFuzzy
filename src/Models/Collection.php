<?php

namespace Bahadircyildiz\PHPFuzzy\Models;

class Collection implements Countable, Extendable, IteratorAggregate{

    private $items = [];

    function getIterator(){
        return new ArrayIterator($this->items);
    }

    function count(){
        return count($this->items);
    }
}
?>