<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
use Bahadircyildiz\PHPFuzzy\Models\{FuzzyNumber as §, PairwiseComparisonMatrix, FuzzyMatrix, EvaluationTagList, EvaluationTag};
use Bahadircyildiz\PHPFuzzy\{ FuzzyMCDM, Utils };
use PHPUnit\Framework\TestCase;

class FuzzyMatrixTest extends TestCase{
    public function testDefineFuzzyMatrixWithEvaluationTag(){
        $etl = new EvaluationTagList([
            new EvaluationTag("V", new §( [1,2,3] ) ),
            new EvaluationTag("B", new §( [12,43,3] ) ),
            new EvaluationTag("G", new §( [3,5,6] ) )
        ]);
        $a = new FuzzyMatrix( [ [ [1,2,4]   , [3,4,5]   , [3,4,5] ] ,  
                                [ [1,2,4]   , "G"       , [3,4,5] ] ,
                                [ "B"       , [3,4,5]   , "V"     ] ] , $etl);
        $expected = new FuzzyMatrix( [  [ [1,2,4]   , [3,4,5]   , [3,4,5]   ] ,  
                                        [ [1,2,4]   , [3,5,6]   , [3,4,5]   ] ,
                                        [ [12,43,3] , [3,4,5]   , [1,2,3]   ] ]);
        $this->assertEquals($expected->getMatrix(), $a->getMatrix());
    }

    public function testCreatePairwiseComparisonMatrix(){
        $rowLabels = ["Hihi", "Haha", "Hohoho"];
        $columnLabels = ["Hoho", "Haha", "Hihihi"];
        $etl = new EvaluationTagList([
            new EvaluationTag("V", new §( [1,2,3] ) ),
            new EvaluationTag("B", new §( [12,43,3] ) ),
            new EvaluationTag("G", new §( [3,5,6] ) )
        ]);
        $a = new PairwiseComparisonMatrix( 
            $rowLabels, $columnLabels,  [ [ [1,2,4] , [3,4,5]   , [3,4,5] ] ,  
                                        [ [1,2,4]   , "G"       , [3,4,5] ] ,
                                        [ "B"       , [3,4,5]   , "V"     ] ] , $etl);
        $expected = new FuzzyMatrix( [  [ [1,2,4]   , [3,4,5]   , [3,4,5]   ] ,  
                                        [ [1,2,4]   , [3,5,6]   , [3,4,5]   ] ,
                                        [ [12,43,3] , [3,4,5]   , [1,2,3]   ] ]);
        $this->assertEquals($expected->getMatrix(), $a->getMatrix()); 
    }

    
}