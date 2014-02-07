<?php 

function reverse($string) { 
	$len = strlen($string); 
	for ($i=0; $i < $len / 2; $i++) { 
		$end = $len - $i - 1; 
		$tmp = $string[$i]; 
		$string[$i] = $string[$end]; 
		$string[$end] = $tmp; 
	}
	unset($i); 
	return $string; 
}

var_dump(reverse("abc")); 
var_dump(reverse("abcd")); 
var_dump(reverse("abcde")); 
var_dump(reverse(""));

?> 