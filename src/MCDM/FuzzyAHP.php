<?php
namespace Bahadircyildiz\PHPFuzzy\MCDM;

use Bahadircyildiz\PHPFuzzy\Utils;


class FuzzyAHP{
    public $dm;
    public $alternatives;
    public $pairwiseMatrices;

    function __constructor(DecisionMaker $dm, array $alternatives){
        $this->dm = $dm;
        $this->alternatives = $alternatives;
    }

    public function createPairwiseMatrices(){
        $criteria = $this->dm->criteria;
        $criteriaSubset = Utils::sampling($criteria, 2);
        var_dump($criteriaSubset);
    }
}

?>