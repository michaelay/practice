<?php
include('binary_search_tree.php');

class BinarySearcyTreeTest extends PHPUnit_Framework_TestCase
{
  // {{{ public function testCreateBinarySearchTree()
  public function testCreateBinarySearchTree()
  {
    // nothing
    $tree = create_binary_search_tree(array());
    $this->assertEquals(NULL, $tree);

    // 1 element
    $input = array(100);
    $tree = create_binary_search_tree($input);
    $this->assertEquals(100, $tree->value);
    $this->assertEquals(NULL, $tree->leftChild);
    $this->assertEquals(NULL, $tree->rightChild);

    // 2 elements
    $input = array(99, 100);
    $tree = create_binary_search_tree($input);
    $this->assertEquals(100, $tree->value);
    $this->assertEquals(99, $tree->leftChild->value);
    $this->assertEquals(NULL, $tree->leftChild->leftChild);
    $this->assertEquals(NULL, $tree->leftChild->rightChild);

    // 3 elemetns
    $input = array(99, 100);
    $tree = create_binary_search_tree($input);
    $this->assertEquals(100, $tree->value);
    $this->assertEquals(99, $tree->leftChild->value);
    $this->assertEquals(NULL, $tree->leftChild->leftChild);
    $this->assertEquals(NULL, $tree->leftChild->rightChild);

    // 4 elements
    $input = array(7, 8, 9, 10);
    $tree = create_binary_search_tree($input);
    $this->assertEquals(9, $tree->value);
    $this->assertEquals(8, $tree->leftChild->value);
    $this->assertEquals(7, $tree->leftChild->leftChild->value);
    $this->assertEquals(NULL, $tree->value->leftChild->rightChild);
    $this->assertEquals(NULL, $tree->value->leftChild->leftChild->leftChild);
    $this->assertEquals(NULL, $tree->value->leftChild->leftChild->rightChild);

    $this->assertEquals(10, $tree->rightChild->value);
    $this->assertEquals(NULL, $tree->value->rightChild->leftChild);
    $this->assertEquals(NULL, $tree->value->rightChild->rightChild);


    $input = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    $tree = create_binary_search_tree($input);

    $this->assertEquals(6, $tree->value);

    $this->assertEquals(3, $tree->leftChild->value);
    $this->assertEquals(9, $tree->rightChild->value);

    $this->assertEquals(2, $tree->leftChild->leftChild->value);
    $this->assertEquals(1, $tree->leftChild->leftChild->leftChild->value);
    $this->assertEquals(NULL, $tree->leftChild->leftChild->rightChild);

    $this->assertEquals(5, $tree->leftChild->rightChild->value);
    $this->assertEquals(4, $tree->leftChild->rightChild->leftChild->value);
    $this->assertEquals(NULL, $tree->leftChild->rightChild->leftChild->leftChild);
    $this->assertEquals(NULL, $tree->leftChild->rightChild->leftChild->rightChild);
    $this->assertEquals(NULL, $tree->leftChild->rightChild->rightChild);

    $this->assertEquals(8, $tree->rightChild->leftChild->value);
    $this->assertEquals(7, $tree->rightChild->leftChild->leftChild->value);
    $this->assertEquals(NULL, $tree->rightChild->leftChild->leftChild->leftChild);
    $this->assertEquals(NULL, $tree->rightChild->leftChild->leftChild->rightChild);
    $this->assertEquals(NULL, $tree->rightChild->leftChild->rightChild);

    $this->assertEquals(10, $tree->rightChild->rightChild->value);
    $this->assertEquals(NULL, $tree->rightChild->rightChild->leftChild);
    $this->assertEquals(NULL, $tree->rightChild->rightChild->rightChild);
  }
  // }}}

  public function test_bfs() {
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $result = array();
    trasverse_bfs($tree, function($node) use ($result) {
        $result[] = $node->value;
    });
    $this->assertEquals(array(5, 3, 8, 2, 4, 7, 9, 1, 6), $result);
  }
}


?>
