<?php

namespace Moorscode\CommandQueue;

/**
 * Class CommandPriority
 * @package Moorscode\CommandQueue
 */
class CommandPriority implements PriorityInterface {
	/**
	 * Sanitizer
	 *
	 * @param int $in_status
	 *
	 * @return int
	 */
	public function sanitize( $in_status ) {
		if ( is_null( $in_status ) ) {
			$in_status = self::NORMAL;
		}

		$status = intval( $in_status );
		$status = min( self::HIGH, max( self::LOW, $status ) );

		if ( $in_status !== $status ) {
			trigger_error( sprintf( 'Priority has been normalized from %s to %d.', $in_status, $status ), E_USER_NOTICE );
		}

		return $status;
	}
}
