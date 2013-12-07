<?php

// ini_set('memory_limit', '1024M');

define('DAY_END', 1440);
define('FILE_MODE', true);
// define('INPUT_FILE', 'input00.txt');
// define('INPUT_FILE', 'input01.txt');
define('INPUT_FILE', 'input03.txt');

list($m, $k) = explode(' ', get_line());
// error_log("m: $m, k: $k");

if ($k == 0) {
  echo "00 00 00 00\n";
  return;
}

// read busy slots
$slots = array();
for ($i=0; $i < $m; $i++) {
  list($h1, $m1, $h2, $m2) = explode(' ', get_line());
  $start = $h1 * 60 + $m1; // inclusive
  // if ($h2 == 0)  {
  //   $h2 = 24;
  // }
  $end = $h2 * 60 + $m2; // not inclusive

  if ($start > 0 && $end == 0) {
    $end = DAY_END;
  }
  error_log("start: $start, end: $end");
  $slots[] = array($start, $end);
}
unset($i);

usort($slots, function($a, $b) {
  if ($a == $b) {
    return 0;
  }
  if ($a < $b) {
    return -1;
  } else {
    return 1;
  }
});

// var_dump($slots);

// merge overlapping slots
$merged_slots = array($slots[0]);
for ($i=1; $i < count($slots); $i++) {
  $current = $slots[$i];
  $prev = $merged_slots[count($merged_slots)-1];
  if ($current[0] <= $prev[1]) { // overlap
    $merged_slots[count($merged_slots)-1] = array($prev[0], max($prev[1], $current[1]));
  } else {
    $merged_slots[] = $current;
  }
}
unset($i);

// var_dump($merged_slots);


// find possible slots
$start = 0;
$available_slots = array();
foreach ($merged_slots as $slot) {
  if ($slot[0] - $start >= $k) {
    $available_slots[] = array($start, $slot[0]);
  }
  $start = $slot[1];
}
unset($slot);

// to day end
if (DAY_END - $start >= $k) {
  $available_slots[] = array($start, DAY_END);
}

// var_dump($available_slots);

// print slots
foreach ($available_slots as $slot) {
  $start_hour = $slot[0] / 60;
  // if ($start_hour == 24) {
  //   $start_hour = 0;
  // }
  $end_hour = $slot[1] / 60;
  if ($end_hour == 24) {
    $end_hour = 0;
  }
  echo sprintf("%02d %02d %02d %02d\n", $start_hour, ($slot[0] % 60), $end_hour, ($slot[1] % 60));
}
unset($slot);

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