<?php

function solution($K, $A) {
    // write your code in PHP5
    
    $avl = new AvlTree();
    $avl->setCompare(function($a, $b) { 
        return $a[0] - $b[0]; 
    });
    
    $count = 0; 
    $len = count($A); 
    
    $start = 0; 
    $end = 0; 
    
    if ($len > 0) { 
        $avl->add(array($A[0], 1));
    }

    while ($start < $len) {
        
        $start_value = $A[$start]; 
        $end_value = $A[$end]; 

        error_log("start: $start, end: $end, ".$avl->first()[0].", ".$avl->last()[0]. ", ".$avl->count());
                        
        if ($avl->last()[0] - $avl->first()[0] <= $K) { // bounded
            
            error_log("bounded: $start, $end");
            $count++; 
            if ($end < $len-1) { 
                                
                $end++; 
                
                if ($avl->contains(array($A[$end], 0))) { 
                    $el = $avl->get(array($A[$end], 0)); 
                    $el[1] = $el[1] + 1; 
                    $avl->add($el); 
                } else { 
                    $avl->add(array($A[$end], 1)); 
                }
                
            } else if ($start < $len-1) { 

                $el = $avl->get(array($start_value)); 
                $el[1] = $el[1] - 1;
                if ($el[1] == 0) { 
                    $avl->remove($el);
                } else { 
                    $avl->add($el); 
                }

                $start++; 

            } else { 
                
                break; 
                
            } 
            
        } else { // not bounded 
            
            if ($start < $len - 1) { 

                $el = $avl->get(array($start_value)); 
                $el[1]--;
                if ($el[1] == 0) { 
                    $avl->remove(array($start_value, 1));
                } else { 
                    $avl->add($el); 
                }

                $start++; 
                
            } else { 
                
                break; 
                
            } 
            
        } 
    } 
    
    return $count; 
}

class BinaryTree {

    /**
     * @var BinaryTree
     */
    private $left = NULL;
    /**
     * @var BinaryTree
     */
    private $right = NULL;

    private $value;

    private $height = 1;

    function __construct($value) {
        $this->value = $value;
    }

    /**
     * @return BinaryTree
     */
    function right() {
        return $this->right;
    }

    /**
     * @return BinaryTree
     */
    function left() {
        return $this->left;
    }

    /**
     * @param BinaryTree $node
     * @return void
     */
    function setRight(BinaryTree $node = NULL) {
        $this->right = $node;
        $this->recalculateHeight();
    }

    /**
     * @param BinaryTree $node
     * @return void
     */
    function setLeft(BinaryTree $node = NULL) {
        $this->left = $node;
        $this->recalculateHeight();
    }

    /**
     * @return int
     */
    function height() {
        return $this->height;
    }

    /**
     * @return int
     */
    function leftHeight() {
        return $this->left === NULL ? 0 : $this->left->height();
    }

    /**
     * @return int
     */
    function rightHeight() {
        return $this->right === NULL ? 0 : $this->right->height();
    }

    /**
     * @return mixed
     */
    function value() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    function setValue($value) {
        $this->value = $value;
    }

    function recalculateHeight() {
        $this->height = max($this->leftHeight(), $this->rightHeight()) + 1;
    }

    /**
     * Note that this function is only safe to call when it has a predecessor.
     * @return BinaryTree
     */
    function inOrderPredecessor() {
        $current = $this->left();
        while ($current->right() !== NULL) {
            $current = $current->right();
        }
        return $current;
    }

    function __clone() {
        $this->left = $this->left === NULL
            ? NULL
            : clone $this->left;

        $this->right = $this->right === NULL
            ? NULL
            : clone $this->right;
    }

}

interface BinarySearchTree extends \Countable {
   
    const TRAVERSE_IN_ORDER = 0;
    const TRAVERSE_LEVEL_ORDER = 1;
    const TRAVERSE_PRE_ORDER = 2;
    const TRAVERSE_POST_ORDER = 3;

    /**
     * @param callable $f
     * @return mixed
     * @throws StateException when the tree is not empty
     */
    function setCompare(callable $f);

    /**
     * @param $a
     * @param $b
     * @return int
     */
    function compare($a, $b);

    /**
     * @param mixed $element
     */
    function add($element);

    /**
     * @param mixed $element
     */
    function remove($element);

    /**
     * @param $element
     *
     * @return mixed
     * @throws LookupException
     */
    function get($element);

    /**
     * @return BinaryTree A copy of the current BinaryTree
     */
    function toBinaryTree();

    /**
     * @return void
     */
    function clear();

    /**
     * @param $item
     *
     * @return bool
     * @throws TypeException when $item is not the correct type.
     */
    function contains($item);

    /**
     * @return mixed
     * @throws EmptyException when the tree is empty
     */
    function first();

    /**
     * @return mixed
     * @throws EmptyException when the tree is empty
     */
    function last();

    /**
     * @return bool
     */
    function isEmpty();

    /**
     * @param int $order [optional]
     *
     * @return BinaryTreeIterator
     */
    function getIterator($order = self::TRAVERSE_IN_ORDER);

}


class AvlTree implements BinarySearchTree {


    /**
     * @return \Iterator
     */
    private function asIterator() {
        if ($this instanceof \IteratorAggregate) {
            return $this->getIterator();
        }
        return $this;
    }

    /**
     * @return bool
     */
    function isEmpty() {
        $i = $this->asIterator();
        $i->rewind();
        return !$i->valid();
    }

    /**
     * @param callable $callback
     */
    function each(callable $callback) {
        $i = $this->asIterator();
        for ($i->rewind(); $i->valid(); $i->next()) {
            $callback($i->current(), $i->key());
        }
    }

    /**
     * @param callable $f
     * @return bool
     */
    function every(callable $f) {
        $i = $this->asIterator();
        for ($i->rewind(); $i->valid(); $i->next()) {
            if (!$f($i->current(), $i->key())) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * @param callable $map
     * @return Enumerator
     */
    function map(callable $map) {
        return new MappingIterator($this->asIterator(), $map);
    }

    /**
     * @param callable $filter
     * @return Enumerator
     */
    function filter(callable $filter) {
        return new FilteringIterator($this->asIterator(), $filter);
    }

    /**
     * @param callable $compare
     * @return bool
     */
    function any(callable $compare) {
        foreach ($this as $value) {
            if ($compare($value)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @param string $separator
     * @return string
     */
    function join($separator) {
        $buffer = '';
        $i = 0;
        foreach ($this as $value) {
            if ($i++ > 0) {
                $buffer .= $separator;
            }
            $buffer .= $value;
        }
        return $buffer;
    }

    /**
     * @param int $n
     * @return Enumerator
     */
    function limit($n) {
        return new LimitingIterator($this->asIterator(), $n);
    }

    /**
     * @param callable $compare
     * @throws StateException
     * @return mixed
     */
    function max(callable $compare = NULL) {
        $i = $this->asIterator();
        $i->rewind();
        if (!$i->valid()) {
            throw new StateException;
        }
        $compare = $compare ?: 'max';
        $max = $i->current();
        for ($i->next(); $i->valid(); $i->next()) {
            $max = $compare($max, $i->current());
        }
        return $max;
    }

    /**
     * @param callable $compare
     * @throws StateException
     * @return mixed
     */
    function min(callable $compare = NULL) {
        $i = $this->asIterator();
        $i->rewind();
        if (!$i->valid()) {
            throw new StateException;
        }
        $compare = $compare ?: 'min';
        $min = $i->current();
        for ($i->next(); $i->valid(); $i->next()) {
            $min = $compare($min, $i->current());
        }
        return $min;
    }

    /**
     * @param callable $f
     * @return bool
     */
    function none(callable $f) {
        $i = $this->asIterator();
        for ($i->rewind(); $i->valid(); $i->next()) {
            if ($f($i->current(), $i->key())) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * @param $initialValue
     * @param callable $combine
     * @return mixed
     */
    function reduce($initialValue, callable $combine) {
        $i = $this->asIterator();
        $carry = $initialValue;
        for ($i->rewind(); $i->valid(); $i->next()) {
            $carry = $combine($carry, $i->current());
        }
        return $carry;
    }

    /**
     * @param int $n
     * @return Enumerator
     */
    function skip($n) {
        return new SkippingIterator($this->asIterator(), $n);
    }

    /**
     * @param int $start
     * @param int $count
     * @return Enumerator
     */
    function slice($start, $count) {
        return new SlicingIterator($this->asIterator(), $start, $count);
    }

    /**
     * @return array
     */
    function toArray() {
        return iterator_to_array($this->asIterator());
    }

    function keys() {
        return new KeyIterator($this->asIterator());
    }

    function values() {
        return new ValueIterator($this->asIterator());
    }
    // use IteratorCollection;

    /**
     * @var BinaryTree
     */
    private $root = NULL;

    /**
     * @var callable
     */
    protected $comparator;

    /**
     * @var BinaryTree
     */
    private $cache = NULL;

    private $size = 0;

    /**
     * @param callable $comparator
     */
    function __construct(callable $comparator = NULL) {
        $this->comparator = $comparator ?: [$this, 'compare'];
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    function compare($a, $b) {
        if ($a < $b) {
            return -1;
        } elseif ($b < $a) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @param mixed $element
     */
    function add($element) {
        $this->root = $this->addRecursive($element, $this->root);
        $this->cache = NULL;
    }

    /**
     * @param $element
     * @param BinaryTree $node
     *
     * @return BinaryTree
     */
    protected function addRecursive($element, BinaryTree $node = NULL) {
        if ($node === NULL) {
            $this->size++;
            return new BinaryTree($element);
        }

        $comparisonResult = call_user_func($this->comparator, $element, $node->value());

        if ($comparisonResult < 0) {
            $node->setLeft($this->addRecursive($element, $node->left()));
        } elseif ($comparisonResult > 0) {
            $node->setRight($this->addRecursive($element, $node->right()));
        } else {
            $node->setValue($element);
        }

        return $this->balance($node);
    }

    /**
     * @param mixed $element
     */
    function remove($element) {
        $this->root = $this->removeRecursive($element, $this->root);
        $this->cache = NULL;
    }

    /**
     * @param $element
     * @param BinaryTree $node
     *
     * @return BinaryTree
     */
    protected function removeRecursive($element, BinaryTree $node = NULL) {
        if ($node === NULL) {
            return NULL;
        }

        $comparisonResult = call_user_func($this->comparator, $element, $node->value());

        if ($comparisonResult < 0) {
            $node->setLeft($this->removeRecursive($element, $node->left()));
        } elseif ($comparisonResult > 0) {
            $node->setRight($this->removeRecursive($element, $node->right()));
        } else {
            //remove the element
            $node = $this->deleteNode($node);
        }

        return $this->balance($node);
    }

    /**
     * @param BinaryTree $node
     *
     * @return BinaryTree
     */
    protected function deleteNode(BinaryTree $node) {
        $left = $node->left();
        $right = $node->right();
        if ($left === NULL) {
            $this->size--;
            if ($right === NULL) {
                // left and right empty
                return NULL;
            } else {
                // left empty, right is not
                unset($node);
                return $right;
            }
        } else {
            if ($right === NULL) {
                // right empty, left is not
                unset($node);
                return $left;
            } else {
                // neither is empty
                $value = $node->inOrderPredecessor()->value();
                $node->setLeft($this->removeRecursive($value, $node->left()));
                $node->setValue($value);
                return $node;
            }
        }
    }

    /**
     * @param $element
     *
     * @return mixed
     * @throws LookupException
     */
    function get($element) {
        $node = $this->root;

        while ($node !== NULL) {
            $comparisonResult = call_user_func($this->comparator, $element, $node->value());

            if ($comparisonResult < 0) {
                $node = $node->left();
            } elseif ($comparisonResult > 0) {
                $node = $node->right();
            } else {
                return $node->value();
            }
        }

        throw new LookupException;
    }

    /**
     * @return BinaryTree A copy of the current BinaryTree
     */
    function toBinaryTree() {
        return $this->root !== NULL
            ? clone $this->root
            : NULL;
    }

    /**
     * @return void
     */
    function clear() {
        $this->root = NULL;
        $this->size = 0;
    }

    /**
     * @param $item
     *
     * @return bool
     * @throws TypeException when $item is not the correct type.
     */
    function contains($item) {
        $node = $this->root;
        while ($node !== NULL) {
            $comparisonResult = call_user_func($this->comparator, $item, $node->value());

            if ($comparisonResult < 0) {
                $node = $node->left();
            } elseif ($comparisonResult > 0) {
                $node = $node->right();
            } else {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * @return mixed
     * @throws EmptyException when the tree is empty
     */
    function first() {
        if ($this->root === NULL) {
            throw new EmptyException();
        }
        $node = $this->root;
        while (($left = $node->left()) !== NULL) {
            $node = $left;
        }
        return $node->value();
    }

    /**
     * @return mixed
     * @throws EmptyException when the tree is empty
     */
    function last() {
        if ($this->root === NULL) {
            throw new EmptyException();
        }
        $node = $this->root;
        while (($right = $node->right()) !== NULL) {
            $node = $right;
        }
        return $node->value();
    }

    // /**
    //  * @return bool
    //  */
    // function isEmpty() {
    //     return $this->root === NULL;
    // }

    /**
     * @param int $order [optional]
     *
     * @return BinaryTreeIterator
     */
    function getIterator($order = self::TRAVERSE_IN_ORDER) {
        $iterator = NULL;

        $root = $this->cache ?: (
        $this->root !== NULL
            ? clone $this->root
            : NULL
        );

        switch ($order) {
            case self::TRAVERSE_LEVEL_ORDER:
                $iterator = new LevelOrderIterator($root, $this->size);
                break;

            case self::TRAVERSE_PRE_ORDER:
                $iterator = new PreOrderIterator($root, $this->size);
                break;

            case self::TRAVERSE_POST_ORDER:
                $iterator = new PostOrderIterator($root, $this->size);
                break;

            case self::TRAVERSE_IN_ORDER:
            default:
                $iterator = new InOrderIterator($root, $this->size);
        }

        return $iterator;

    }

    /**
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    function count() {
        return $this->size;
    }

    function __clone() {
        $this->root = $this->root === NULL
            ? NULL
            : clone $this->root;
    }

    /**
     * @param BinaryTree $node
     *
     * @return BinaryTree
     */
    protected function balance(BinaryTree $node = NULL) {
        if ($node === NULL) {
            return NULL;
        }

        $diff = $node->leftHeight() - $node->rightHeight();

        if ($diff < -1) {
            // right side is taller
            $node = $this->rotateLeft($node);
        } elseif ($diff > 1) {
            // left side is taller
            $node = $this->rotateRight($node);
        }

        return $node;
    }

    /**
     * @param BinaryTree $root
     *
     * @return BinaryTree
     */
    protected function rotateRight(BinaryTree $root) {
        $leftNode = $root->left();
        $leftHeight = $leftNode->leftHeight();
        $rightHeight = $leftNode->rightHeight();

        $diff = $leftHeight - $rightHeight;

        if ($diff < 0) {
            // Left-Right case
            $pivot = $leftNode->right();
            $leftNode->setRight($pivot->left());
            $pivot->setLeft($leftNode);
            $root->setLeft($pivot);
        }

        $pivot = $root->left();
        $root->setLeft($pivot->right());
        $pivot->setRight($root);

        return $pivot;
    }

    /**
     * @param BinaryTree $root
     *
     * @return BinaryTree
     */
    protected function rotateLeft(BinaryTree $root) {
        $rightNode = $root->right();

        $diff = $rightNode->leftHeight() - $rightNode->rightHeight();

        if ($diff >= 0) {
            // Right-Left case
            $pivot = $rightNode->left();
            $rightNode->setLeft($pivot->right());
            $pivot->setRight($rightNode);
            $root->setRight($pivot);
        }


        $pivot = $root->right();
        $root->setRight($pivot->left());
        $pivot->setLeft($root);

        return $pivot;
    }

    /**
     * @param callable $f
     * @return mixed
     * @throws StateException when the tree is not empty
     */
    function setCompare(callable $f) {
        if ($this->root !== NULL) {
            throw new StateException('Cannot set compare function when the BinarySearchTree is not empty');
        }
        $this->comparator = $f;
    }

}


var_dump(solution(2, array(3, 5, 7, 6, 3)));


?>
