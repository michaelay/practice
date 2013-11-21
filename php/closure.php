<?php

$name2 = 'name 2';
$foo = function($name) use ($name2) {
  echo $name."\n";
  echo $name2."\n";
};

$foo("hahah");

