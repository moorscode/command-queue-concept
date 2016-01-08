<?php

namespace Moorscode\CommandQueue;

use Moorscode\TestCommand;

require 'autloader.php';

$storage = new MemoryStorage();
//$storage = new TestStorage();

$queue = new CommandQueue( $storage );
$queue->add( new TestCommand( '25' ), 25 );
$queue->add( new TestCommand( 'normal 1' ) );
$queue->add( new TestCommand( 'normal 2' ) );
$queue->add( new TestCommand( 'normal 3' ) );
$queue->add( new TestCommand( 'LOW' ), CommandPriority::LOW );

$id = $queue->add( new TestCommand( '-25' ), - 25 );
$queue->stack( new TestCommand( 'HIGH, but prerequisite -25' ), $id, CommandPriority::HIGH );

$queue->add( new TestCommand( 'HIGH' ), CommandPriority::HIGH );


do {
	$result = $queue->next();
	echo '<br>';
} while ( ! is_null( $result ) );
