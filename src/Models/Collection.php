<?php

namespace PHPFuzzy\Models;

/**
 * Class Collection
 * @package PHPFuzzy\Models
 */
class Collection implements \Countable, \IteratorAggregate{

    protected $items = [];

    /**
     * Collection constructor.
     * @param $items
     */
    function __construct($items){
        $this->items = $items;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    function getIterator(){
        return new \ArrayIterator($this->items);
    }

    /**
     * @return int
     */
    function count(){
        return count($this->items);
    }

    /**
     * @param null $index
     * @return array|mixed
     */
    function get($index = null){
        return $index !== null ? $this->items[$index] : $this->items;
    }

    /**
     * @return mixed
     */
    function getRandom(){
        $index = array_rand($this->items, 1);
        return $this->items[$index];
    }
}
?>