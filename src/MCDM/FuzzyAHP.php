<?php
namespace PHPFuzzy\MCDM;

use PHPFuzzy\Models\{ DecisionMaker, AlternativeList };


class FuzzyAHP{
    public $dm;
    public $alternatives;
    public $pairwiseMatrices = [];

    function __construct(DecisionMaker $dm, AlternativeList $alternatives){
        $this->dm = $dm;
        $this->alternatives = $alternatives;
    }


}

?>