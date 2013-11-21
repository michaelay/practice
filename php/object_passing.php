<?php

class Node {
  public $value = 'test';
}

$node = new Node();
$node->value = '123';

echo "before {$node->value}.\n";

function update_node_value(Node $node, $value)
{
  $node->value = $value ;
}

update_node_value($node, 'changed');
echo "after {$node->value}.\n";
