<?php

/**
 * Class CommandQueue
 */
class CommandQueue {
	/**
	 * CommandQueue constructor.
	 *
	 * @param CommandQueueStorageInterface $storage
	 */
	public function __construct( CommandQueueStorageInterface $storage = null ) {
		$this->storage = $storage;
	}

	/**
	 * @param CommandInterface $command
	 * @param CommandPriority $priority
	 *
	 * @return mixed
	 */
	public function add( CommandInterface $command, CommandPriority $priority = null ) {
		$priority = is_null( $priority ) ? new CommandPriority() : $priority;
		$priority = (string) $priority;

		// Add to storage
		return $this->storage->addCommand( $command, $priority );
	}

	/**
	 * Run the next item from the queue.
	 *
	 * @return null|bool Nul on empty queue, bool from execution result.
	 */
	public function next() {
		$identifier = uniqid( 'cmd_' );

		// Get from storage
		$command = $this->storage->getNextCommand( $identifier );
		if ( false === $command ) {
			return null;
		}

		$result = $command->execute();

		$this->storage->finishCommand( $identifier, $result );

		return $result;
	}
}
