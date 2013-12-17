<?php

// spl test 

$queue = new SplQueue(); 
$queue->enqueue('123'); 
$queue->enqueue('hello');
$queue->enqueue(5);
$queue->enqueue(array(1, 2, '123'));
$queue->enqueue(NULL);

while (!$queue->isEmpty()) {
	var_dump($queue->dequeue());
}