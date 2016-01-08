<?php

namespace Moorscode\CommandQueue;

/**
 * Class Priority
 */
class CommandPriority {
	const HIGH = 1000;
	const NORMAL = 0;
	const LOW = - 1000;

	/**
	 * @var mixed
	 */
	private $status;

	/**
	 * Priority constructor.
	 *
	 * @param int $in_status
	 */
	public function __construct( $in_status = self::NORMAL ) {
		$status = intval( $in_status );
		$status = min( self::HIGH, max( self::LOW, $status ) );

		if ( $in_status !== $status ) {
			trigger_error( sprintf( 'Priority has been normalized from %s to %d.', $in_status, $status ), E_USER_NOTICE );
		}

		$this->status = $status;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return (string) $this->status;
	}
}
