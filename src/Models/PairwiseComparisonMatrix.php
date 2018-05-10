<?php

namespace PHPFuzzy\Models;

class PairwiseComparisonMatrix extends FuzzyMatrix {

    protected $labelOptions;
    protected $criterion;


    function __construct(object $labelOptions, array $matrix, EvaluationTagList $etl = null){
        parent::__construct($matrix, $etl);
        $this->validateLabels($labelOptions);
        $this->labelOptions = $labelOptions; 
        return $this;
    }

    private function validateLabels(object $labelOptions){
        $this->validateLabelOptionMembers($labelOptions);
        $this->checkLabelCount($labelOptions->m, $labelOptions->n);
    }
    
    private function checkLabelCount(array $mLabels, array $nLabels){
        list($checkM, $checkN) = [ $this->getM() == count($mLabels), $this->getN() == count($nLabels)];
        $checkM or die("Error in label dimensions m, expected ".$this->getM().", returned ".count($mLabels).".");   
        $checkN or die("Error in label dimensions n, expected ".$this->getN().", returned ".count($nLabels).".");
    }

    private function validateLabelOptionMembers($labelOptions){
        $labelOptions->m or die("Parameter m in Label options are missing.");
        $labelOptions->n or die("Parameter n in Label options are missing.");
    }



    public function getLabels(){
        return $labelOptions;
    }







}
?>