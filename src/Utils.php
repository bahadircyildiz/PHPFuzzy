<?php

namespace Bahadircyildiz\PHPFuzzy;

class Utils{

    public static function sampling($arrayset, $size, $combinations = array()) {

        # if it's the first iteration, the first set 
        # of combinations is the same as the set of characters
        if (empty($combinations)) {
            $combinations = $arrayset;
        }
    
        # we're done if we're at size 1
        if ($size == 1) {
            return $combinations;
        }
    
        # initialise array to put new values in
        $new_combinations = array();
    
        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($arrayset as $elem) {
                if(gettype($combination) == "array")
                    $new_combinations[] = array_merge($combination, [ $elem ]);
                else
                    $new_combinations[] = [ $combination, $elem ];
            }
        }
    
        # call same function again for the next iteration
        return sampling($chars, $size - 1, $new_combinations);
    
    }
}

?>