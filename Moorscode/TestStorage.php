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

		printf( '<br>DBQ: Adding command at priority %s.', $priority );

		$id = uniqid();

		$item = new QueueItem( new TestCommand( 'Test Command.' ), CommandPriority::NORMAL );
		$item->setIdentifier( $id );
		$this->queue[$id] = $item;

		return $id;

	}

	/**
	 * Get the next item from the queue and connect identifier to it
	 *
	 * @return CommandInterface
	 */
	public function getNextCommand() {

		echo '<br>DBQ: Getting next command.';

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

		printf( '<br>DBQ: Stacking command after %s.', $after_command_id );

		return new QueueItem( new TestCommand( sprintf( '<br>DBQ: Stacked after %s.', $after_command_id ) ), CommandPriority::NORMAL );

	}

	/**
	 * @param QueueItem $item
	 * @param bool $succes
	 *
	 * @return bool
	 */
	public function finishCommand( QueueItem $item, $succes ) {

		printf( '<br>DBQ: Finishing command %s.', $item->getIdentifier() );

	}
}
