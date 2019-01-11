<?php

namespace PHPFuzzy;

use PHPFuzzy\Models\{FuzzyNumber};

/**
 *  A sample class
 *
 *  Use this section to define what this class is doing, the PHPDocumentator will use this
 *  to automatically generate an API documentation using this information.
 *
 * @author Bahadir Can Yildiz
 */
class FuzzyOperations
{

    /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */

    /**
     * Sample method
     *
     * Always create a corresponding docblock for each method, describing what it is for,
     * this helps the phpdocumentator to properly generator the documentation
     *
     * @param FuzzyNumber $a
     * @param FuzzyNumber $b
     * @return string
     */

    private static function lengthCheck(FuzzyNumber &$a, FuzzyNumber &$b)
    {
        $ca = $a->length();
        $cb = $b->length();
        if ($ca != $cb) {
            $maxLength = max($ca, $cb);
            if ($maxLength == $ca) {
                $b->value[] = $b->value[2];
                $b->value[2] = $b->value[1];
            } else {
                if ($maxLength == $cb) {
                    $a->value[] = $a->value[2];
                    $a->value[2] = $a->value[1];
                }
            }
        }
    }

    /**
     * @param FuzzyNumber $a
     * @param FuzzyNumber $b
     * @return FuzzyNumber
     */
    public static function sum(FuzzyNumber $a, FuzzyNumber $b)
    {
        self::lengthCheck($a, $b);
        $result = array();
        foreach ($a->value as $i => $v) {
            $result[] = $a->value[$i]->x + $b->value[$i]->x;
        }
        return new FuzzyNumber($result);
    }

    /**
     * @param FuzzyNumber $a
     * @param FuzzyNumber $b
     * @return FuzzyNumber
     */
    public static function subtract(FuzzyNumber $a, FuzzyNumber $b)
    {
        $b_reverse = new FuzzyNumber(array_reverse($b->value));
        return self::sum($a, $b_reverse);
    }

    /**
     * @param FuzzyNumber $a
     * @param FuzzyNumber $b
     * @return FuzzyNumber
     */
    public static function multiply(FuzzyNumber $a, FuzzyNumber $b)
    {
        self::lengthCheck($a, $b);
        $result = array();
        foreach ($a->value as $i => $v) {
            $result[] = $a->value[$i]->x * $b->value[$i]->x;
        }
        return new FuzzyNumber($result);
    }

    /**
     * @param FuzzyNumber $a
     * @param FuzzyNumber $b
     * @return FuzzyNumber
     */
    public static function divide(FuzzyNumber $a, FuzzyNumber $b)
    {
        $b_reverse = new FuzzyNumber(array_reverse($b->value));
        return self::multiply($a, $b_reverse);
    }
}
