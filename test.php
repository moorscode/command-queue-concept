<?php

namespace Moorscode\CommandQueue;

use Moorscode\TestCommand;
use Moorscode\TestStorage;

require 'autloader.php';

$storage = new MemoryStorage();
//$storage = new TestStorage();

$queue = new CommandQueue( $storage );
$queue->add( new TestCommand( '25' ), 25 );
$queue->add( new TestCommand( 'normal 1' ) );
$queue->add( new TestCommand( 'LOW' ), CommandPriority::LOW );
$queue->add( new TestCommand( 'normal 2' ) );
$queue->add( new TestCommand( 'normalized', 2.14 ) );
$queue->add( new TestCommand( 'normal 3' ) );

$id = $queue->add( new TestCommand( '-25' ), -25 );
$queue->stack( $id, new TestCommand( 'HIGH, but prerequisite -25' ), CommandPriority::HIGH );

$queue->add( new TestCommand( 'HIGH' ), CommandPriority::HIGH );


do {
	$result = $queue->next();
	echo '<br>';
} while ( ! is_null( $result ) );
