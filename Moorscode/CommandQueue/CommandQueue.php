<?php

namespace Moorscode\CommandQueue;

/**
 * Class CommandQueue
 * @package Moorscode\CommandQueue
 */
class CommandQueue {
	/**
	 * @var CommandPriority
	 */
	private $prioritySanitizer;

	/**
	 * CommandQueue constructor.
	 *
	 * @param StorageInterface $storage
	 * @param PriorityInterface $prioritySanitizer
	 */
	public function __construct( StorageInterface $storage, PriorityInterface $prioritySanitizer = null ) {
		$this->storage           = $storage;
		$this->prioritySanitizer = is_null( $prioritySanitizer ) ? new CommandPriority() : $prioritySanitizer;
	}

	/**
	 * Add a new command to the queue
	 *
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return mixed
	 */
	public function add( CommandInterface $command, $priority = null ) {
		if ( ! is_null( $priority ) && ! is_numeric( $priority ) ) {
			throw new \InvalidArgumentException( 'Expected number got ' . gettype( $priority ) );
		}

		$priority = $this->prioritySanitizer->sanitize( $priority );

		// Add to storage
		return $this->storage->addCommand( $command, $priority );
	}

	/**
	 * Stack a command after another
	 *
	 * @param string|int $prerequisite ID
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return mixed
	 */
	public function stack( $prerequisite, CommandInterface $command, $priority = CommandPriority::NORMAL ) {
		if ( empty( $prerequisite ) ) {
			throw new \InvalidArgumentException( 'Prerequisite cannot be empty.' );
		}

		if ( ! is_string( $prerequisite ) && ! is_integer( $prerequisite ) ) {
			throw new \InvalidArgumentException( 'Prequisite expected to be integer or string got ' . gettype($prerequisite ) );
		}

		if ( ! is_numeric( $priority ) ) {
			throw new \InvalidArgumentException( 'Priority expected to be number got ' . gettype( $priority ) );
		}

		$priority = $this->prioritySanitizer->sanitize( $priority );

		// Add to storage
		return $this->storage->stackCommand( $prerequisite, $command, $priority );
	}

	/**
	 * Run the next item from the queue.
	 *
	 * @return null|bool Nul on empty queue, bool from execution result.
	 */
	public function next() {
		// Get from storage
		$command = $this->storage->getNextCommand();
		if ( empty( $command ) ) {
			return null;
		}

		$result = $command->execute();

		$this->storage->finishCommand( $command, $result );

		return $result;
	}
}
