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

  //     5  
 //   3,     8 
//  2, 4   7  9 
// 1      6

  public function test_bfs() {
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $result = array();
    trasverse_bfs($tree, function($node) use (&$result) {
        $result[] = $node->value;
    });
    $this->assertEquals(array(5, 3, 8, 2, 4, 7, 9, 1, 6), $result);
  }

  // dfs pre order
  public function test_trasverse_preorder() {
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $result = array();
    trasverse_preorder($tree, function($node) use (&$result) {
        $result[] = $node->value;
    });
    $this->assertEquals(array(5, 3, 2, 1, 4, 8, 7, 6, 9), $result);
  }

  // dfs in order
  public function test_trasverse_inorder() {
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $result = array();
    trasverse_inorder($tree, function($node) use (&$result) {
        $result[] = $node->value;
    });
    $this->assertEquals(array(1, 2, 3, 4, 5, 6, 7, 8, 9), $result);
  }

  // dfs post order
  public function test_trasverse_postorder() { 
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $result = array();
    trasverse_postorder($tree, function($node) use (&$result) {
        $result[] = $node->value;
    });
    $this->assertEquals(array(1, 2, 4, 3, 6, 7, 9, 8, 5), $result);
  }

  public function test_find() { 
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $node2 = bst_find($tree, 2); 
    $node8 = bst_find($tree, 8); 

    $this->assertEquals(NULL, bst_find($tree, 5.5)); 
    $this->assertEquals(NULL, bst_find($tree, -1)); 
    $this->assertEquals(NULL, bst_find($tree, 100)); 

    $result = array(); 
    trasverse_bfs($node2, function($node) use (&$result) { 
        $result[] = $node->value;
    }); 
    $this->assertEquals(array(2, 1), $result); 

    $result = array(); 
    trasverse_bfs($node8, function($node) use (&$result) { 
        $result[] = $node->value;
    }); 
    $this->assertEquals(array(8, 7, 9, 6), $result); 

    $this->assertEquals(NULL, bst_find(NULL, 1)); 
  }

  public function test_bst_find_leftmost() { 
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $this->assertEquals(1, bst_find_leftmost($tree)->value); 
  }

  public function test_bst_find_rightmost() {
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $this->assertEquals(9, bst_find_rightmost($tree)->value); 

    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10));
    $this->assertEquals(10, bst_find_rightmost($tree)->value); 
  }

  // bst_find_inorder_next  
  public function test_bst_find_inorder_successor() { 
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $this->bsd_find_inorder_successor($tree, 0, NULL);
    $this->bsd_find_inorder_successor($tree, 1, 2);
    $this->bsd_find_inorder_successor($tree, 2, 3);
    $this->bsd_find_inorder_successor($tree, 3, 4);
    $this->bsd_find_inorder_successor($tree, 4, 5);
    $this->bsd_find_inorder_successor($tree, 5, 6);
    $this->bsd_find_inorder_successor($tree, 6, 7);
    $this->bsd_find_inorder_successor($tree, 7, 8);
    $this->bsd_find_inorder_successor($tree, 8, 9);
    $this->bsd_find_inorder_successor($tree, 9, NULL);
    $this->bsd_find_inorder_successor($tree, 10, NULL);

    $tree = create_binary_search_tree(array());
    $this->bsd_find_inorder_successor($tree, 0, NULL);

    $this->bsd_find_inorder_successor(NULL, 0, NULL);
  }

  // just to save some typing. don't do this in production code, no decoupling. depends on tree value structure
  private function bsd_find_inorder_successor($tree, $needle, $value) { 
    $node = bst_find($tree, $needle);
    $this->assertEquals($value, bst_find_inorder_successor($tree, $node)->value); 
  }

  // bst_find_inorder_previous 
  public function test_bsd_find_inorder_predecessor() {     
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $this->bsd_find_inorder_predecessor($tree, 0, NULL);
    $this->bsd_find_inorder_predecessor($tree, 1, NULL);
    $this->bsd_find_inorder_predecessor($tree, 2, 1);
    $this->bsd_find_inorder_predecessor($tree, 3, 2);
    $this->bsd_find_inorder_predecessor($tree, 4, 3);
    $this->bsd_find_inorder_predecessor($tree, 5, 4);
    $this->bsd_find_inorder_predecessor($tree, 6, 5);
    $this->bsd_find_inorder_predecessor($tree, 7, 6);
    $this->bsd_find_inorder_predecessor($tree, 8, 7);
    $this->bsd_find_inorder_predecessor($tree, 9, 8);
    $this->bsd_find_inorder_predecessor($tree, 10, NULL);

    $tree = create_binary_search_tree(array());
    $this->bsd_find_inorder_predecessor($tree, 3, NULL);
    $this->bsd_find_inorder_predecessor(NULL, 2, NULL);
  }

  // just to save some typing. don't do this in production code, no decoupling. depends on tree value structure
  private function bsd_find_inorder_predecessor($tree, $needle, $value) { 
    $node = bst_find($tree, $needle);
    $this->assertEquals($value, bst_find_inorder_predecessor($tree, $node)->value); 
  }

  public function test_bst_add() { 
    $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));
    $ret = bst_add($tree, 0); 
    $this->assertTrue($ret); 
    $ret = bst_add($tree, 1);
    $this->assertTrue($ret); 
    $ret = bst_add($tree, 4); 
    $this->assertTrue($ret); 
    $ret = bst_add($tree, 8); 
    $this->assertTrue($ret); 
    $ret = bst_add($tree, 9); 
    $this->assertTrue($ret); 
    $ret = bst_add($tree, 100); 
    $this->assertTrue($ret); 
  }

  public function test_bst_delete() { 
    // $tree = create_binary_search_tree(array(1, 2, 3, 4, 5, 6, 7, 8, 9));


    // $tree = NULL;
    // $this->assertFalse(bst_delete($tree, NULL));
  }

}


?>
