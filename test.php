<?php

require 'autloader.php';

$storage = new MemoryQueueStorage();
//$storage = new TestQueueStorage();

$queue = new CommandQueue( $storage );
$queue->add( new TestCommand(), new CommandPriority( CommandPriority::HIGH ) );
$queue->add( new AnotherTestCommand(), new CommandPriority( 25 ) );
$queue->add( new AnotherTestCommand(), new CommandPriority() );
$queue->add( new TestCommand(), new CommandPriority() );
$queue->add( new TestCommand(), new CommandPriority() );
$queue->add( new TestCommand(), new CommandPriority() );
$queue->add( new AnotherTestCommand(), new CommandPriority( - 25 ) );
$queue->add( new TestCommand(), new CommandPriority( CommandPriority::LOW ) );

do {
	$result = $queue->next();
	echo '<br>';
} while ( ! is_null( $result ) );
