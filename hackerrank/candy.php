<?php

define('FILE_MODE', true);
define('INPUT_FILE', 'candy.txt'); 

$num_cases = (int)get_line(); 

for ($i=0; $i<$num_cases; $i++) { 
    $line = get_line(); 
    list($n, $c, $m) = explode(' ', $line); 
    $num = solve_case($n, $c, $m); 
    echo $num."\n";
}

function solve_case($n, $c, $m) {
    $wrap = floor($n / $c); 
    $total = $wrap;
    while ($wrap >= $m) { 
    	$extra = floor($wrap / $m); 
 	   	$total += $extra; 
 	   	$wrap = $wrap % $m + $extra; 
	}
    return $total; 
}

function get_line() {
  static $lines = NULL;
  if (FILE_MODE) {
    if ($lines == NULL) {
      $input_string = file_get_contents(INPUT_FILE);
      $lines = explode("\n", $input_string);
      reset($lines);
      return current($lines);
    } else {
      return next($lines);
    }
  } else {
    return trim(fgets(STDIN));
  }
}

?>