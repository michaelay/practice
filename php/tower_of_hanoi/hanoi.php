<?php

/**
 * num of 1, 2, 3, .... $num on first stack, 1 is smallest disc
 * 3 towers 
 * moving to third tower 
 */ 
function hanoi($num) { 
	if ($num == 0) { 
		return 0; 
	}
	if ($num == 1) { 
		return 1; 
	}	
	if ($num == 2) { 
		return 1 + 2 * hanoi($num - 1); // do DP
	}
}

// TODO: use 2 variables for DP instead of array
function hanoi_dp($num) { 
	$cache = array(0 => 0, 1 => 1); 
	$sum = 0; 
	for ($i=1; $i < $num; $i++) { 
		$sum += 2 * $cache[i - 1] + 1;
		$cache[$i] = $sum; 
	}
	unset($i); 
	return $sum; 
}