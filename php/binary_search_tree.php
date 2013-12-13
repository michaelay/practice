<?php

class Node {
  public $leftChild = NULL;
  public $rightChild = NULL;
  public $value = 0;

  public function __construct($value, $left = NULL, $right = NULL) {
    $this->leftChild = $left;
    $this->rightChild = $right;
    $this->value = $value;
  }

  // preorder
  public function trasverse_preorder_bfs(closure $callback = NULL) {
    $queue = array();
    $queue[] = $this;

    while (!empty($queue)) {

      $currentNode = array_shift($queue);

      if ($callback) {
        $callback($currentNode);
      }

      if ($currentNode->leftChild) {
        $queue[] = $currentNode->leftChild;
      }

      if ($currentNode->rightChild) {
        $queue[] = $currentNode->rightChild;
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
    return NULL;
  }

  $num = count($numbers);

  if ($num == 1) {
    return new Node($numbers[0]);
  }

  $root_index = (int)floor((float)$num / 2.0);
  $leftTree = create_binary_search_tree(array_slice($numbers, 0, $root_index));
  $rightTree = create_binary_search_tree(array_slice($numbers, $root_index + 1));
  return new Node($numbers[$root_index], $leftTree, $rightTree);
}

// $input = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
// $tree = create_binary_search_tree($input);

// $tree->trasverse_preorder_bfs(function (Node $node) {
//   echo $node->value."\n";
// });

//$tree->trasverse_preorder(NULL);
