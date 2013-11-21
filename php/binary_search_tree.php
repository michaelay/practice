<?php

class Node {
  public $leftChild = null;
  public $rightChild = null;
  public $value = 0;

  public function __construct($value, $left = null, $right = null) {
    $this->leftChild = $left;
    $this->rigthChild = $right;
    $this->value = $value;
  }

  // preorder
  public function trasverse_preorder(closure $callback = NULL) {
    $queue = array();
    $queue[] = $this;

    while (!empty($queue)) {
      $currentNode = array_shift($queue);
      if ($currentNode->leftChild) {
        $queue[] = $currentNode->leftChild;
      }
      if ($currentNode->rightChild) {
        $queue[] = $currentNode->rightChild;
      }

      if ($callback) {
        $callback($this);
      }
    }
  }

  // inorder
  public function trasverse_inorder(closure $callback = NULL) {
  }

  // dfs
  public function trasverse_postorder(closure $callback = NULL) {
  }
}

function create_binary_search_tree(array $numbers) {
  if (empty($numbers)) {
    return null;
  }

  $num = count($numbers);

  if ($num == 1) {
    return new Node($numbers[0]);
  }

  if ($num == 2) {
    $childNode = new Node($number[0]);
    $parentNode = new Node($number[1], $childNode, null);
    return $parentNode;
  }

  $root_index = floor($num / 2);
  $leftTree = create_binary_search_tree(array_slice($numbers, 0, $root_index));
  $rightTree = create_binary_search_tree(array_splice($numbers, $root_index + 1, $num - $root_index - 1));
  return new Node($numbers[$root_index], $leftTree, $rightTree);
}

$input = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
$tree = create_binary_search_tree($input);

$tree->trasverse_preorder(function (Node $node) {
  echo $node->value."\n";
});

$tree->trasverse_preorder(NULL);
