<?php

namespace Moorscode\CommandQueue;

/**
 * Class MemoryStorage
 * @package Moorscode\CommandQueue
 */
class MemoryStorage implements StorageInterface {

	/**
	 * @var array
	 */
	private $commands = array();

	/**
	 * @var array
	 */
	private $priority = array();

	/**
	 * @var array
	 */
	private $processing = array();

	/**
	 * @var int
	 */
	private $completed = 0;

	/**
	 * @var int
	 */
	private $succeeded = 0;

	/**
	 * @var int
	 */
	private $failed = 0;

	/**
	 * Add command to the queue
	 *
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return bool
	 */
	public function addCommand( CommandInterface $command, $priority ) {
		return $this->addCommandItem( new QueueItem( $command, $priority ) );
	}

	/**
	 * @param string $after_command_id
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return bool
	 */
	public function stackCommand( $after_command_id, CommandInterface $command, $priority ) {
		$item = new QueueItem( $command, $priority );
		$item->setPrerequiste( $after_command_id );

		return $this->addCommandItem( $item );
	}

	/**
	 * @param QueueItem $item
	 *
	 * @return string
	 */
	private function addCommandItem( QueueItem $item ) {
		$priority = $item->getPriority();
		if ( ! isset( $this->priority[ $priority ] ) ) {
			$this->priority[ $priority ] = array();
		}

		$id = uniqid();

		$item->setIdentifier( $id );
		$this->priority[ $priority ][] = $id;
		$this->commands[ $id ]         = $item;

		return $id;
	}

	/**
	 * Get the next item from the queue and connect identifier to it
	 *
	 * @return CommandInterface
	 */
	public function getNextCommand() {
		if ( empty( $this->commands ) ) {
			return false;
		}

		// Local copy of array.
		$test = $this->priority;

		$found = false;

		while ( false === $found ) {
			// Checked all, none found. Exit.
			if ( empty( $test ) ) {
				return false;
			}

			$keys = array_keys( $test );
			rsort( $keys, SORT_NUMERIC );
			$index = current($keys);

			// Get next item in current priority.
			$id = array_shift( $test[ $index ] );

			// Clean up, so we move to the next priority.
			if ( empty( $test[ $index ] ) ) {
				unset( $test[ $index ] );
			}

			if ( ! isset( $this->commands[ $id ] ) ) {
				return false;
			}

			// Get the command for the identifier.
			$item = $this->commands[ $id ];

			$prerequisite = $item->getPrerequisite();
			if ( is_null( $prerequisite ) || ! isset( $this->commands[ $prerequisite ] ) ) {
				$found = true;
			}
		}

		$id_index = array_search( $id, $this->priority[ $index ] );
		unset( $this->priority[ $index ][ $id_index ] );

		// Clean up.
		if ( empty( $this->priority[ $index ] ) ) {
			unset( $this->priority[ $index ] );
		}

		// Remove from commands stack, push into processing stack.
		unset( $this->commands[ $id ] );
		$this->processing[ $id ] = $item;

		return $item;
	}

	/**
	 * @param QueueItem $item
	 * @param bool $succes
	 *
	 * @return bool
	 */
	public function finishCommand( QueueItem $item, $succes = true ) {
		$id = $item->getIdentifier();
		if ( ! isset( $this->processing[ $id ] ) ) {
			return false;
		}

		unset( $this->processing[ $id ] );

		$this->completed ++;
		if ( $succes ) {
			$this->succeeded ++;
		} else {
			$this->failed ++;
		}

		return true;
	}
}