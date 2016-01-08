<?php

namespace Moorscode\CommandQueue;

/**
 * Created by PhpStorm.
 * User: jip
 * Date: 07/01/16
 * Time: 23:09
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
	 * @param CommandInterface $command
	 * @param string $after_command_id
	 * @param int $priority
	 *
	 * @return bool
	 */
	public function stackCommand( CommandInterface $command, $after_command_id, $priority ) {
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

		$this->priority[ $priority ][] = $id;

		$this->commands[ $id ] = $item;

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

		$test = $this->priority;

		$found = false;
		while ( false === $found ) {
			if ( empty( $test ) ) {
				return false;
			}

			$keys = array_keys( $test );
			rsort( $keys, SORT_NUMERIC );

			$id = array_shift( $test[ $keys[0] ] );

			// Clean up.
			if ( empty( $test[ $keys[0] ] ) ) {
				unset( $test[ $keys[0] ] );
			}

			if ( ! isset( $this->commands[ $id ] ) ) {
				return false;
			}

			$item = $this->commands[ $id ];

			$prerequisite = $item->getPrerequisite();
			if ( is_null( $prerequisite ) || ! isset( $this->commands[ $prerequisite ] ) ) {
				$found = true;
			}
		}

		$index = array_search( $id, $this->priority[ $keys[0] ] );
		unset( $this->priority[ $keys[0] ][ $index ] );

		// Clean up.
		if ( empty( $this->priority[ $keys[0] ] ) ) {
			unset( $this->priority[ $keys[0] ] );
		}

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
	public function finishCommand( QueueItem $item, $succes ) {
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