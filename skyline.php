<?php

define('START', 1); 
define('END', 2);

function skyline(array $input) { 
	$points = array(); 
	foreach($input as $i) { 
		$points[] = array($i[0], $i[1], START); 
		$points[] = array($i[2], $i[1], END); // x, height, type
	}
	unset($i);

	usort($points, function($a, $b) { 
		return $a[0] - $b[0]; // comparing x
	});

	// $max_heap = new SplMaxHeap();

	foreach($points as $point) { 
		if ($point[2] == START) { 
			// $max_heap->insert($point[1]); // add the height
			$bst_tree->insert height
		} else { 
			$bst_tree->remove height
		}
		$result[x] = $bst_tree->get_max
	}
	return $result;
}

$result = skyline(array(array(1, 10, 300), array(0, 5, 10), array(9, 400, 13)));



?>