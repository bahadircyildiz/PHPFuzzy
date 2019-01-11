<?php

namespace PHPFuzzy\Models;

use PHPFuzzy\Utils;

/**
 * Class PairwiseComparisonMatrixList
 * @package PHPFuzzy\Models
 */
class PairwiseComparisonMatrixList extends Collection
{

    /**
     * PairwiseComparisonMatrixList constructor.
     * @param array $items
     * @throws \Exception
     */
    function __construct(array $items = [])
    {
        Utils::validateArrayAsCollection($items, PairwiseComparisonMatrix::class);
        $this->items = $items;
        return $this;
    }

    /**
     * @param PairwiseComparisonMatrix $pcm
     */
    public function add(PairwiseComparisonMatrix $pcm)
    {
        $this->items[] = $pcm;
    }

    /**
     * @return array
     */
    public function getAllRoadMaps()
    {
        return array_map(function ($e) {
            return $e->getRoadMap();
        }, $this->items);
    }

    /**
     * @param $comparedWith
     * @return array
     */
    public function findPCMByComparedWith($comparedWith)
    {
        $toArr = Utils::iteratorToArray($this);
        $result = array_filter($toArr, function ($e) use ($comparedWith) {
            return $e->getComparisonInfo["comparedWith"] == $comparedWith;
        })[0];
        return $result;
    }

}

?>