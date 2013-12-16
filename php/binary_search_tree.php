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
}

// bfs
function trasverse_bfs($root, closure $callback = NULL) {
  $queue = array($root);

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

// dfs preorder
function trasverse_preorder($root, closure $callback = NULL) {
  if ($root == NULL) { 
    return; 
  }

  // visit current node 
  if ($callback) {
    $callback($root);
  }

  trasverse_preorder($root->leftChild, $callback); 
  trasverse_preorder($root->rightChild, $callback); 
}

// dfs in order
function trasverse_inorder($root, closure $callback = NULL) {
  if ($root == NULL) { 
    return; 
  }

  trasverse_inorder($root->leftChild, $callback); 

  // visit current node 
  if ($callback) {
    $callback($root);
  }

  trasverse_inorder($root->rightChild, $callback); 
}

// dfs post order
function trasverse_postorder($root, closure $callback = NULL) {
  if ($root == NULL) { 
    return; 
  }

  trasverse_postorder($root->leftChild, $callback); 
  trasverse_postorder($root->rightChild, $callback); 

  // visit current node 
  if ($callback) {
    $callback($root);
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

// return node if found, NULL otherwise 
function bst_find_leftmost($root) { 
  while ($root->leftChild != NULL) { 
    $root = $root->leftChild; 
  }
  return $root; 
}

function bst_find_rightmost($root) { 
  while ($root->rightChild != NULL) { 
    $root = $root->rightChild; 
  }
  return $root; 
}

function bst_find($root, $needle) { 
  while ($root != NULL) { 
    if ($root->value == $needle) { 
      return $root;
    }

    if ($needle > $root->value) {
      $root = $root->rightChild; 
    } else { 
      $root = $root->leftChild; 
    }
  }
  return $root;
}

function bst_find_inorder_successor($root, $node) {
  if ($node == NULL) { 
    return NULL;
  }

  if ($node->rightChild !== NULL) { 
    return bst_find_leftmost($node->rightChild); 
  } 

  $successor_node = NULL;
  while ($root != NULL) { 
    if ($node->value < $root->value) { 
      $successor_node = $root; 
      $root = $root->leftChild; 
    } else if ($node->value > $root->value) { 
      $root = $root->rightChild;
    } else { 
      break;
    }
  }
  return $successor_node;
}

function bst_find_inorder_predecessor($root, $node) { 
  if ($node == NULL) { 
    return NULL;
  }

  if ($node->leftChild !== NULL) { 
    return bst_find_rightmost($node->leftChild); 
  } 

  $predecessor_node = NULL;
  while ($root != NULL) { 
    if ($node->value < $root->value) { 
      $root = $root->leftChild; 
    } else if ($node->value > $root->value) { 
      $predecessor_node = $root;
      $root = $root->rightChild; 
    } else {
      break; 
    }
  }
  
  return $predecessor_node;
}
// $input = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
// $tree = create_binary_search_tree($input);
