<?php

// get number of cases if not already
$number_of_cases = parse_number_of_cases();
if (!$number_of_cases) {
  exit(2);
}

// handle each case
for ($case = 0; $case < $number_of_cases; ++$case) {
  parse_case($case);
}

function get_next_line() {
  static $lines = NULL;
  if ($lines === NULL) {
    $input_file = 'square_detector_example_input2.txt';
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

function parse_case($case) {
  // get number of rows
  $number_rows = get_int_from_line();
  if (!$number_rows) {
    return false;
  }

  $case_number = $case + 1;
  if (!parse_shape2($number_rows)) {
    echo "Case #{$case_number}: NO\n";
  } else {
    echo "Case #{$case_number}: YES\n";
  }
}

// helper
function parse_shape2($number_rows) {
  $start_row = -1;
  $start_col = -1;
  $end_row = -1;
  $end_col = -1;

  for ($i=0; $i < $number_rows; $i++) {
    $line = get_next_line();

    if ($start_row == -1) { // search

      list($ret, $start, $end) = parse_line($line);
      if ($ret) {
        $start_col = $start;
        $end_col = $end;
        $start_row = $i;
        $end_row = $i + $end - $start;
      } else {
        for ($j=0; $j < $number_rows - $i - 1; ++$j) {
          get_next_line();
        }
        return false;
      }

    } else {

      // check if fits
      if ($start_row <= $i && $i <= $end_row) {

        list($ret, $start, $end) = parse_line($line);
        if ($ret) {
          if ($start == $start_col && $end == $end_col) {
            continue;
          } else {
            for ($j=0; $j < $number_rows - $i - 1; ++$j) {
              get_next_line();
            }
            return false;
          }
        } else {
          for ($j=0; $j < $number_rows - $i - 1; ++$j) {
            get_next_line();
          }
          return false;
        }

      } else {
        if (!is_line_empty($line)) {
          for ($j=0; $j < $number_rows - $i - 1; ++$j) {
            get_next_line();
          }
          return false;
        }
      }

    }
  }

  if ($start_row == -1) {
    return false;
  } else {
    return true;
  }
}

function is_line_empty($line) {
  for ($i=0; $i < strlen($line); $i++) {
    if ($line[$i] != '.') {
      return false;
    }
  }
  return true;
}

function parse_line($line) {
  $start = -1;
  $end = -1;
  for ($i=0; $i < strlen($line); $i++) {
    if ($line[$i] == '.') { // empty
      if ($start == -1) { // not started
        continue;
      } else if ($end == -1) { // not ended
        $end = $i - 1;
      } else {  // ended
        continue;
      }
    } else { // black
      if ($start == -1) { // not started
        $start = $i;
      } else if ($end == -1) { // not ended
        continue;
      } else {  // ended
        return array(false, 0, 0);
      }
    }
  }

  if ($start == -1) {
    return array(false, 0, 0);
  }
  if (($start != -1) && ($end == -1)) {
    $end = $i - 1;
  }
  unset($i);
  return array(true, $start, $end);
}

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
  if (!$line) {
    return false;
  }
  return intval($line);
}

?>
