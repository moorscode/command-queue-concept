<?php

namespace Moorscode\CommandQueue;

use Moorscode\TestCommand;
use Moorscode\AnotherTestCommand;

require 'autloader.php';

$storage = new MemoryStorage();
//$storage = new TestStorage();

$queue = new CommandQueue( $storage );
$queue->add( new TestCommand( '25' ), new CommandPriority( 25 ) );
$queue->add( new TestCommand( 'normal 1' ), new CommandPriority() );
$queue->add( new TestCommand( 'normal 2' ), new CommandPriority() );
$queue->add( new TestCommand( 'normal 3' ), new CommandPriority() );
$queue->add( new TestCommand( 'LOW' ), new CommandPriority( CommandPriority::LOW ) );

$id = $queue->add( new TestCommand( '-25' ), new CommandPriority( - 25 ) );
$queue->stack( new TestCommand( 'HIGH, but prerequisite -25' ), $id, new CommandPriority( CommandPriority::HIGH ) );


do {
	$result = $queue->next();
	echo '<br>';
} while ( ! is_null( $result ) );
