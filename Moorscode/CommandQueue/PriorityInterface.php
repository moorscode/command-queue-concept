<?php

namespace Moorscode\CommandQueue;

/**
 * Interface PriorityInterface
 * @package Moorscode\CommandQueue
 */
interface PriorityInterface {
	const HIGH = 1000;
	const NORMAL = 0;
	const LOW = - 1000;

	/**
	 * Sanitize priority
	 *
	 * @param int $in_status
	 *
	 * @return int
	 */
	public function sanitize( $in_status );
}