<?php

// ini_set('memory_limit', '1024M');

define('FILE_MODE', true);
//define('FILE_MODE', false);
define('INPUT_FILE', 'input00.txt');

$num_cases = intval(get_line());
for ($i=0; $i < $num_cases; $i++) {
  $k = intval(get_line());
  list($f, $d) = find_common_fab($k);
  echo "$f $d\n";
}
unset($i);

function find_common_fab($k) {
  $prev_fab = 1;
  $current_fab = 2;
  $ret = has_common($k, $current_fab);
  while(!$ret) {
    $tmp = $prev_fab;
    $prev_fab = $current_fab;
    $current_fab += $tmp;
    $ret = has_common($k, $current_fab);
  }
  return array($current_fab, $ret); // f and d
}

function has_common($k, $fab) {
  // error_log("k: $k, fab: $fab");
  for ($d = 2; $d <= min($k ,$fab); $d = get_next_prime($d)) {
    if ($k % $d == 0 && $fab % $d == 0) {
      return $d;
    }
  }
  return false;
}

function get_next_prime($d) {
  static $prime_next = array();
  if (isset($prime_next[$d])) {
    return $prime_next[$d];
  //   while ()
  } else {
    $next_prime = false;
    $curr = ($d % 2 == 0) ? $d - 1 : $d;

    while (!$next_prime) { // loop until found next prime
      $curr += 2;
      // error_log("curr: $curr");
      // sleep(1);

      $fail = false;
      foreach($prime_next as $prime => $dummy) {
        if ($prime > sqrt($curr)) {
          break;
        }
        if ($curr % $prime == 0) {
          $fail = true;
          break;
        }
      }
      unset($prime);
      unset($dummy);

      if (!$fail) {
        $next_prime = $curr;
      }
    }
    $prime_next[$d] = $next_prime;
    return $next_prime;
  }
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