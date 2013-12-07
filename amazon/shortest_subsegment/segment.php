<?php

define('FILE_MODE', true);
define('INPUT_FILE', 'input00.txt');
define('EMPTY_OUTPUT', 'NO SUBSEGMENT FOUND');

// filter other than a-zA-Z, make lower case.
// $input = strtolower(get_line());
$input = get_line();
$input = preg_replace('/[^a-zA-Z ]/', '', $input);
// $input = filter(get_line());
$input_array = explode(' ', $input);
// error_log($input);
// var_dump($input_array);
$input_array_lower = [];
foreach($input_array as $word) {
	$input_array_lower[] = strtolower($word);
}
unset($word);
// var_dump($input_array_lower);


$num_words = intval(get_line());
// error_log($num_words);

$words = array();
for ($i=0; $i<$num_words; $i++) {
	$words[] = filter(get_line());
}
unset($i);

var_dump($words);
$word_mapping = array_flip($words);
error_log("word mapping===");
var_dump($word_mapping);

// create required mapping
$required_mapping = array();
foreach($words as $word) {
	$key = $word_mapping[$word];
	if (!isset($required_mapping[$key])) {
		$required_mapping[$key] = 1;
	} else {
		$required_mapping[$key]++;
	}
}
unset($key);
unset($word);

error_log("required mapping==");
var_dump($required_mapping);

// create input mapping
$input_mapping = array();
$input_count = count($input_array_lower);
$skip_count = 0;
for ($i=0; $i < $input_count; $i++) {
	// echo $input_array_lower[$i]."\n";
	// $input_mapping[$i] =
	$word = $input_array_lower[$i];
	if (isset($word_mapping[$word])) {
		$input_mapping[] = array($word_mapping[$word], $i, $skip_count);
		$skip_count = 0;
	} else {
		$skip_count++;
	}
}
unset($i);
error_log("mapping");
var_dump($input_mapping);

// input mapping: mapping, offset, skipped count before this word
$match_found = false;
$match_start = -1;
$match_end = -1;
$match_len = 0;

$mcount = count($input_mapping);
for ($i=0; $i < $mcount; $i++) {
	$value = $input_mapping[$i][0];
	if (isset($required_mapping[$value])) {
		if ($match_start == -1) {
			$match_start = $input_mapping[$i][1];
		}
		$required_mapping[$value]--;
		if ($required_mapping[$value] == 0) {
			unset($required_mapping[$value]);
		}
		if (empty($required_mapping)) {
			$match_found = true;
			$match_end = $input_mapping[$i][1];
			$match_len = $match_end - $match_start + 1;
		}
	}

}
unset($i);

// error_log("match: $match_found, $match_start, $match_end");

if (!$match_found) {
	echo EMPTY_OUTPUT."\n";
} else {
	// $output_string = "";
	for ($i=$match_start; $i<$match_end; $i++) {
		echo $input_array[$i]." ";
	}
	unset($i);
	// $output_string
	echo $input_array[$match_end];
}



function filter($string) {
	return preg_replace('/[^a-z ]/', '', strtolower($string));
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