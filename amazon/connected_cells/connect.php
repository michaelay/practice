<?php

// ini_set('memory_limit', '1024M');

define('FILE_MODE', true);
//define('FILE_MODE', false);
define('INPUT_FILE', 'input00.txt');

$num_cases = intval(get_line());
for ($i=0; $i < $num_cases; $i++) {
	echo "".process_case()."\n";
}
unset($i);

function process_case() {
	global $m, $dimension;

	// get dimension
	$dimension = intval(get_line());

	$m = array();
	for ($i=0; $i < $dimension; $i++) {
		$m[$i] = explode(' ', get_line());
	}
	unset($i);

	// error_log($m[0][0]);
	// error_log($m[$dimension-1][$dimension-1]);
	$num_connected_sets = 0;
	for ($x=0; $x < $dimension; $x++) {
		for ($y=0; $y < $dimension; $y++) {
			$num_connected_sets += trasverse_connected_set($x, $y);
		}
	}
	unset($x);

	return $num_connected_sets;
}

function trasverse_connected_set($x, $y) {
	global $m, $dimension;

	if ($m[$x][$y] == -1) { // visited
		return 0;
	}
	if ($m[$x][$y] == 0) {
		return 0;
	}

	$queue = array();
	array_push($queue, array($x, $y));
	while (!empty($queue)) {
		$element = array_shift($queue);
		$ex = $element[0];
		$ey = $element[1];

		if ($m[$ex][$ey] == 1) {
			$m[$ex][$ey] = -1; // mark as visited
			// push children
			if ($ex < $dimension-1) {
				array_push($queue, array($ex+1, $ey));
			}
			if ($ex > 0) {
				array_push($queue, array($ex-1, $ey));
			}
			if ($ey < $dimension-1) {
				array_push($queue, array($ex, $ey+1));
			}
			if ($ey > 0) {
				array_push($queue, array($ex, $ey-1));
			}
			if ($ex < $dimension-1 && $ey < $dimension-1) {
				array_push($queue, array($ex+1, $ey+1));
			}
			if ($ex < $dimension-1 && $ey > 0) {
				array_push($queue, array($ex+1, $ey-1));
			}
			if ($ex > 0 && $ey < $dimension-1) {
				array_push($queue, array($ex-1, $ey+1));
			}
			if ($ex > 0 && $ey > 0) {
				array_push($queue, array($ex-1, $ey-1));
			}

		}
	}

	return 1;
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