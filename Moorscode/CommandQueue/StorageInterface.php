<?php

namespace Moorscode\CommandQueue;

/**
 * Created by PhpStorm.
 * User: jip
 * Date: 07/01/16
 * Time: 19:37
 */
interface StorageInterface {
	/**
	 * Add command to the queue
	 *
	 * @param CommandInterface $command
	 * @param int $priority
	 *
	 * @return mixed
	 */
	public function addCommand( CommandInterface $command, $priority );

	/**
	 * @param CommandInterface $command
	 * @param string $after_command_id
	 * @param int $priority
	 *
	 * @return mixed
	 */
	public function stackCommand( CommandInterface $command, $after_command_id, $priority );
	/**
	 * Get the next item from the queue and connect identifier to it
	 *
	 * @return bool|QueueItem
	 */
	public function getNextCommand();

	/**
	 * @param QueueItem $item
	 * @param bool $succes
	 *
	 * @return bool
	 */
	public function finishCommand( QueueItem $item, $succes );
}
