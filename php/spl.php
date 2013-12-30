<?php

// spl test 

// $queue = new SplQueue(); 
// $queue->enqueue('123'); 
// $queue->enqueue('hello');
// $queue->enqueue(5);
// $queue->enqueue(array(1, 2, '123'));
// $queue->enqueue(NULL);

// while (!$queue->isEmpty()) {
// 	var_dump($queue->dequeue());
// }


// spl heap 

class MicMaxHeap extends SplMaxHeap { 
	public function compare($a, $b) { 
		return $a - $b; 
	}
}

class MicMinHeap extends SplMinHeap { 
	// public function compare($a, $b) { 
	// 	return $a - $b; 
	// }
}

class MicHeap extends SplHeap {
	public function compare($a, $b) { 
		return $a - $b; 
	}
}

$heap = new MicMinHeap(); 

$heap->insert(1); 
$heap->insert(3); 
$heap->insert(12); 
$heap->insert(8); 
$heap->insert(9); 
$heap->insert(5); 
$heap->insert(3); 
$heap->insert(2);

print_heap($heap);
// print_heap($heap);

function print_heap($heap) { 
	echo "print heap\n";
	foreach($heap as $value) { 
		echo "$value\n";
	}
	unset($value);  
}

// doubly linked list 

$dlist = new SplDoublyLinkedList(); 
$dlist->push('1'); 
$dlist->unshift('3'); 
$dlist->unshift('5');

foreach ($dlist as $item) { 
	echo "dlist: $item\n";
}
unset($item);	

$dlist->rewind(); 
while ($dlist->valid()) { 
	echo "dlist: {$dlist->current()}\n";
	$dlist->next(); 
}

$dlist->rewind(); 
$dlist->next();
$dlist->next();
while ($dlist->valid()) { 
	echo "dlist: {$dlist->current()}\n";
	$dlist->prev();
}

// priority queue 
echo "priority queue...\n";

$pq = new SplPriorityQueue(); 
$pq->insert('a', 10); 
$pq->insert('b', 110); 
$pq->insert('c', 13); 
$pq->insert('d', 23); 
$pq->insert('e', -1); 

foreach($pq as $element) { 
	echo $element."\n";
}
unset($lement);


class ReversePriorityQueue extends SplPriorityQueue { 
	public function compare($a, $b) { 
		return $b - $a; 
	}
}

$pq = new ReversePriorityQueue(); 
$pq->insert('a', 10); 
$pq->insert('b', 110); 
$pq->insert('c', 13); 
$pq->insert('d', 23); 
$pq->insert('e', -1); 

foreach($pq as $element) { 
	echo $element."\n";
}
unset($lement);

