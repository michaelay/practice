<?php

function solution($K, $A) {
    // write your code in PHP5

    $count = 0; 
    $len = count($A);
    $start = 0; 
    $end = $start;

    while ($start < $len) { 
        // $end = $start;
        $max = $A[$start];
        $min = $A[$start]; 
        $subcount = 0;

        while ($end < $len) { 
            $end_value = $A[$end];
            if ($end_value < $min) { 
                $min = $end_value; 
            } 
            if ($end_value > $max) { 
                $max = $end_value;                 
            }

            if ($max - $min <= $K) { 
                // $subcount++; 
                $end++; 
            } else { 
                // $end++;
                break;
            }
        }

        $subcount = $end - $start; 
        error_log("$start, $end, $subcount");

        $count += $subcount; 
        $start++;
        $end = $start + $subcount; 

        // $count += ($subcount + 1) * $subcount / 2; 
        // $start = $start + $subcount; 
    }     

    return $count; 
}

var_dump(solution(2, array(3, 5, 7, 6, 3)));

?>
