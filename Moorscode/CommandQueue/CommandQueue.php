<?php

namespace Moorscode\CommandQueue;

/**
 * Class CommandQueue
 */
class CommandQueue {
	/**
	 * CommandQueue constructor.
	 *
	 * @param StorageInterface $storage
	 */
	public function __construct( StorageInterface $storage = null ) {
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
	 * @param CommandInterface $command
	 * @param string $prerequisite ID
	 * @param CommandPriority $priority
	 *
	 * @return mixed
	 */
	public function stack( CommandInterface $command, $prerequisite, CommandPriority $priority = null ) {
		$priority = is_null( $priority ) ? new CommandPriority() : $priority;
		$priority = (string) $priority;

		// Add to storage
		return $this->storage->stackCommand( $command, $prerequisite, $priority );
	}

	/**
	 * Run the next item from the queue.
	 *
	 * @return null|bool Nul on empty queue, bool from execution result.
	 */
	public function next() {
		// Get from storage
		$command = $this->storage->getNextCommand();
		if ( false === $command ) {
			return null;
		}

		$result = $command->execute();

		$this->storage->finishCommand( $command, $result );

		return $result;
	}
}
