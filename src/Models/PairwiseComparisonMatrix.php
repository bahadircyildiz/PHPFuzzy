<?php

namespace PHPFuzzy\Models;

class PairwiseComparisonMatrix extends FuzzyMatrix {

    protected $mLabels;
    protected $nLabels;
    protected $criterion;

    
    function __construct(array $mLabels, array $nLabels, Criterion $c = null, array $matrix, EvalutionTagList $etl = null){
        parent::__construct($matrix, $etl);
        $this->checkLabelCount($mLabels, $nLabels);
        $this->criterion = $c ?? null;
        $this->mLabels = $mLabels;
        $this->nLabels = $nLabels;
        return $this;
    }







}
?>