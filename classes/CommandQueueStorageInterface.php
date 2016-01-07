<?php

/**
 * Created by PhpStorm.
 * User: jip
 * Date: 07/01/16
 * Time: 19:37
 */
interface CommandQueueStorageInterface {
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
	 * Get the next item from the queue and connect identifier to it
	 *
	 * @param string $identifier
	 *
	 * @return bool||CommandInterface
	 */
	public function getNextCommand( $identifier );

	/**
	 * @param string $identifier
	 * @param bool $succes
	 *
	 * @return bool
	 */
	public function finishCommand( $identifier, $succes );
}
