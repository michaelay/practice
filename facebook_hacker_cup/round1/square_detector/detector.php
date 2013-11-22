<?php


// get number of cases if not already
$number_of_cases = parse_number_of_cases();
if (!$number_of_cases) {
  exit(2);
}

// handle each case
for ($case = 0; $case < $number_of_cases; ++$case) {
  parse_case();
}

function get_next_line() {
  static $lines = NULL;
  if ($lines === NULL) {
    $input_file = 'square_detector_example_input.txt';
    $input_string = file_get_contents($input_file);
    $lines = explode("\n", $input_string);
    reset($lines);
    return current($lines);
  } else {
    return next($lines);
  }
}

// return 0 if error
function parse_number_of_cases() {
  return get_int_from_line();
}

function parse_case() {
  // get number of rows
  $number_rows = get_int_from_line();
  var_dump("num rows");
  var_dump($number_rows);
  if (!$number_rows) {
    return false;
  }

  if (!parse_shape()) {
    echo "Case #1: NO\n";
  } else {
    echo "Case #1: NO\n";
  }
/*
  $start_col = -1;
  $start_row = -1;
  for ($row = 0; $row < $number_rows; ++$row) {
    list($ret, $start, $end) = parse_square_row();
    if (!$ret) {
      return false;
    } else {
      // validate
      if ($start
    }
  }
   */
}

// helper
// return true, start, end if valid
// else return false, start, end
function parse_square_row() {
  $start = -1;
  $end = -1;

  $line = get_next_line();
  if ($line) {
    return false;
  }
  for ($i=0; $i < strlen($line); ++$i) {
    $char = $line[$i];
    if ($char === '.') {
      if ($start == -1 && $end == -1) { // not started, not ended
        continue;
      }
      if ($start != -1 && $end == -1) {  // started, not ended
        $end = $i;
        continue;
      }
      if ($start != -1 && $end != -1) { // started, ended
        continue;
      }
      if ($start == -1 && $end != -1) { // not started, ended, weird
        return array(false, $start, $end);
      }
    } else if ($char === '#') {
      if ($start == -1 && $end == -1) { // not started, not ended
        $start = $i;
        continue;
      }
      if ($start != -1 && $end == -1) {  // started, not ended
        continue;
      }
      if ($start != -1 && $end != -1) { // started, ended
        return array(false, $start, $end);
      }
      if ($start == -1 && $end != -1) { // not started, ended, weird
        return array(false, $start, $end);
      }
    } else {
      return array(false, $start, $end);
    }

  }
  return array(true, $start, $end);
}

function get_int_from_line() {
  $line = get_next_line();
  var_dump($line);
  if (!$line) {
    return false;
  }
  return intval($line);
}

?>
