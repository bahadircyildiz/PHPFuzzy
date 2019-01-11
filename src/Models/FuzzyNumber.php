<?php

namespace PHPFuzzy\Models;

use MathPHP\NumericalAnalysis\NumericalIntegration\SimpsonsRule;

/**
 *  A sample class
 *
 *  Use this section to define what this class is doing, the PHPDocumentator will use this
 *  to automatically generate an API documentation using this information.
 *
 * @author Bahadir Can Yildiz
 */
class FuzzyNumber implements \Countable, \IteratorAggregate
{

    /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
    // private $m_SampleProperty = '';

    /**
     * Sample method
     *
     * Always create a corresponding docblock for each method, describing what it is for,
     * this helps the phpdocumentator to properly generator the documentation
     *
     * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
     *
     * @return string
     */
    public $value;
    protected $raw;

    /**
     * FuzzyNumber constructor.
     * @param $arr
     */
    function __construct($arr)
    {
        $this->raw = $arr;
        $this->fixToStandart($arr);
        $this->value = $arr;
    }

    /**
     * @return int
     */
    function count()
    {
        return count($this->value);
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    function getIterator()
    {
        return new \ArrayIterator($this->value);
    }

    /**
     * @return string
     */
    function __toString()
    {
        $seperator = function ($e) {
            return "$e->ux;$e->x";
        };
        $fnStr = implode(',', array_map($seperator, $this->value));
        $return = "({$fnStr})";
        return $return;
    }

    /**
     * @param array $arr
     */
    private function fixToStandart(array &$arr)
    {
        foreach ($arr as $key => &$value) {
            if (is_integer($value)) {
                if (count($arr) == 3) {
                    $value = $key % 2 . ";" . $value;
                } else {
                    if (count($arr) == 4) {
                        if ($key == 0 || $key == 3) {
                            $value = "0;" . $value;
                        } else {
                            $value = "1;" . $value;
                        }
                    }
                }
            }
            if (is_string($value)) {
                $temp = explode(";", $value);
                if (count($temp) > 1) {
                    $value = (object)array("ux" => (int)$temp[0], "x" => (int)$temp[1]);
                }
            }
        }
    }

    /**
     * @return int
     */
    public function length()
    {
        return count($this->value);
    }

    /**
     * @return bool
     */
    public function isTriangular()
    {
        if ($this->length() == 3) {
            foreach ($this->value as $key => $value) {
                if ($value->ux != $key % 2) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isTrapezoid()
    {
        if ($this->length() == 4) {
            foreach ($this->value as $key => $value) {
                if ($key == 0 || $key == 3) {
                    if ($value->ux != 0) {
                        return false;
                    }
                } else {
                    if ($key == 1 || $key == 2) {
                        if ($value->ux != 1) {
                            return false;
                        }
                    }
                }
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * In following workarounds, Number has 3 main attributes
     *
     * Core:         x | Ma(x) = 1
     * Support:      x | Ma(x) <= 0
     * Boundary:     x | 0 < Ma(x) < 1
     *
     * @param string $type
     * @param array $options
     * @return string
     */
    public function defuzzificate($type = 'CoA', $options = array())
    {
        switch ($type) {
            case 'CoA':
                return $this->defuzzificate_coa($options);
        }
    }

    /**
     * @param $x
     * @return float|int|null
     */
    public function µ($x)
    {
        $v = $this->value;
        if ($this->isTriangular()) {
            if ($x >= $v[0]->x && $x < $v[1]->x) {
                return ($x - $v[0]->x) / ($v[1]->x - $v[0]->x);
            } else {
                if ($x >= $v[1]->x && $x < $v[2]->x) {
                    return ($v[2]->x - $x) / ($v[2]->x - $v[1]->x);
                } else {
                    return null;
                }
            }
        } else {
            if ($this->isTrapezoid()) {
                if ($x >= $v[0]->x && $x < $v[1]->x) {
                    return ($x - $v[0]->x) / ($v[1]->x - $v[0]->x);
                } else {
                    if ($x >= $v[1]->x && $x < $v[2]->x) {
                        return 1;
                    } else {
                        if ($x >= $v[2]->x && $x < $v[3]->x) {
                            return ($v[3]->x - $x) / $v[3]->x - $v[2]->x;
                        } else {
                            return null;
                        }
                    }
                }
            }
        };
    }

    private function defuzzificate_coa($o)
    {
        $v = $this->value;
        list($start, $end, $n) = [$v[0]->x, $v[$this->length() - 1]->x, $v[$this->length() - 1]->x - $v[0]->x];
        if (array_key_exists('n', $o)) {
            $n = $o['n'];
        }
        return
            SimpsonsRule::approximate(function ($x) {
                return $x * $this->µ($x);
            }, $start, $end, $n + 1)
            /
            SimpsonsRule::approximate(function ($x) {
                return $this->µ($x);
            }, $start, $end, $n + 1);
    }

    public function l()
    {
        return $this->value[0]->x;
    }

    public function m()
    {
        return $this->value[1]->x;
    }

    public function u()
    {
        return $this->value[2]->x;
    }

    public function vectorize()
    {
        $total = 0;
        foreach ($this->value as $i => $val) {
            $total += $val->x;
        }
        return new FuzzyNumber(array_map(function ($e) {
            $newX = $e->x / $total;
            return "{$e->ux};{$newX}";
        }, $this->value));
    }

}