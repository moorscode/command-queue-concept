<?php

namespace Moorscode\CommandQueue;

class TestStorage implements StorageInterface {
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
	}

	/**
	 * Get the next item from the queue and connect identifier to it
	 *
	 * @param string $identifier
	 *
	 * @return CommandInterface
	 */
	public function getNextCommand( $identifier ) {
		// TODO: Implement getNextCommand() method.
		echo 'DBQ: Getting next command.<br>';
		return new TestCommand();
	}

	/**
	 * @param string $identifier
	 * @param bool $succes
	 *
	 * @return bool
	 */
	public function finishCommand( $identifier, $succes ) {
		// TODO: Implement finishCommand() method.
		printf( 'DBQ: Finishing command %s.<br>', $identifier );
	}
}