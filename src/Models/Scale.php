<?php

namespace PHPFuzzy\Models;

/**
 * Class Scale
 * @package PHPFuzzy\Models
 * @property string $tag
 * @property FuzzyNumber $value
 * @property string $definition
 */
class Scale
{

    public $tag;
    public $value;
    public $definition;

    /**
     * Scale constructor.
     * @param string $tag
     * @param FuzzyNumber $value
     * @param null $definition
     */
    function __construct(string $tag, FuzzyNumber $value, $definition = null)
    {
        $this->tag = $tag;
        $this->value = $value;
        $this->definition = $definition;
    }
}

?>