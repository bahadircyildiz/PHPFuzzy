<?php
namespace Bahadircyildiz\PHPFuzzy\MCDM;

use Bahadircyildiz\PHPFuzzy\{ DecisionMaker, Utils };


class FuzzyAHP{
    public $dm;
    public $alternatives;
    public $pairwiseMatrices = [];

    function __construct(DecisionMaker $dm, array $alternatives){
        $this->dm = $dm;
        $this->alternatives = $alternatives;
    }

    public function createPairwiseMatrices(){
        
    }
}

?>