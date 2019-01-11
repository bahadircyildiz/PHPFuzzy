<?php

namespace PHPFuzzy\Models;

use PHPFuzzy\Utils;

/**
 * Class ScaleList
 * @package PHPFuzzy\Models
 */
class ScaleList extends Collection
{

    /**
     * ScaleList constructor.
     * @param array $items
     * @throws \Exception
     */
    function __construct(array $items = [])
    {
        Utils::validateArrayAsCollection($items, Scale::class);
        parent::__construct($items);
    }

    /**
     * @param Scale $tag
     */
    function add(Scale $tag)
    {
        $this->items[] = $tag;
    }

    /**
     * @param string $tag
     * @return null
     */
    function getValueByTag(string $tag)
    {
        $returnTag = function ($e) use ($tag) {
            return $e->tag == $tag;
        };
        $result = array_values(array_filter($this->items, $returnTag));
        return $result[0]->value ?: null;
    }

}

?>