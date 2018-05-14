<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
use PHPFuzzy\Models\{FuzzyNumber as §, PairwiseComparisonMatrix, FuzzyMatrix, ScaleList, Scale,
                     AlternativeList, Alternative};
use PHPFuzzy\{ FuzzyMCDM, Utils , Fake};
use PHPUnit\Framework\TestCase;

class FuzzyMatrixTest extends TestCase{
    public function testDefineFuzzyMatrixWithScale(){
        $sL = new ScaleList([
            new Scale("V", new §( [1,2,3] ) ),
            new Scale("B", new §( [12,43,3] ) ),
            new Scale("G", new §( [3,5,6] ) )
        ]);
        $a = new FuzzyMatrix( [ [ [1,2,4]   , [3,4,5]   , [3,4,5] ] ,  
                                [ [1,2,4]   , "G"       , [3,4,5] ] ,
                                [ "B"       , [3,4,5]   , "V"     ] ] , $sL);
        $expected = new FuzzyMatrix( [  [ [1,2,4]   , [3,4,5]   , [3,4,5]   ] ,  
                                        [ [1,2,4]   , [3,5,6]   , [3,4,5]   ] ,
                                        [ [12,43,3] , [3,4,5]   , [1,2,3]   ] ]);
        $this->assertEquals($expected->getMatrix(), $a->getMatrix());
    }

    public function testCreatePairwiseComparisonMatrix(){
        $pairs = new AlternativeList(Fake::Alternative(3));
        $comparedWith = Fake::Criterion()[0];
        $sL = new ScaleList([
            new Scale("V", new §( [1,2,3] ) ),
            new Scale("B", new §( [12,43,3] ) ),
            new Scale("G", new §( [3,5,6] ) )
        ]);
        $a = new PairwiseComparisonMatrix($pairs, $comparedWith ,   [ [ [1,2,4]   , [3,4,5] , [3,4,5] ] ,  
                                                                    [   [1,2,4]   , "G"     , [3,4,5] ] ,
                                                                    [   "B"       , [3,4,5] , "V"     ]   ] , $sL);
        $expected = new FuzzyMatrix( [  [ [1,1,1]   , [3,4,5]   , [3,4,5]   ] ,  
                                        [ [1,2,4]   , [1,1,1]   , [3,4,5]   ] ,
                                        [ [12,43,3] , [3,4,5]   , [1,1,1]   ] ]);
        $this->assertEquals($expected->getMatrix(), $a->getMatrix()); 
    }

    
}