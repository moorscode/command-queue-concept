<?php

namespace Moorscode;

use Moorscode\CommandQueue\StorageInterface;
use Moorscode\CommandQueue\CommandInterface;
use Moorscode\CommandQueue\QueueItem;
use Moorscode\CommandQueue\CommandPriority;

/**
 * Class TestStorage
 * @package Moorscode\CommandQueue
 */
class TestStorage implements StorageInterface {

	private $queue = array();

	/**
	 * Add command to the queue
	 *
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return bool
	 */
	public function addCommand( CommandInterface $command, $priority ) {
		printf( 'DBQ: Adding command at priority %s.<br>', $priority );

		$this->queue[] = new QueueItem( new TestCommand( 'Test Command.' ), CommandPriority::NORMAL );
	}

	/**
	 * Get the next item from the queue and connect identifier to it
	 *
	 * @return CommandInterface
	 */
	public function getNextCommand() {

		// TODO: Implement getNextCommand() method.
		echo 'DBQ: Getting next command.<br>';

		return array_pop( $this->queue );
	}


	/**
	 * @param string $after_command_id
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return mixed
	 */
	public function stackCommand( $after_command_id, CommandInterface $command, $priority ) {
		printf( 'DBQ: Stacking command after %s.<br>', $after_command_id );

		return new QueueItem( new TestCommand( sprintf( 'DBQ: Stacked after %s.', $after_command_id ) ), CommandPriority::NORMAL );
	}

	/**
	 * @param QueueItem $item
	 * @param bool $succes
	 *
	 * @return bool
	 */
	public function finishCommand( QueueItem $item, $succes ) {
		printf( 'DBQ: Finishing command %s.<br>', $item->getIdentifier() );
	}
}
