<?php

namespace Moorscode;

use Moorscode\CommandQueue\CommandInterface;

/**
 * Created by PhpStorm.
 * User: jip
 * Date: 07/01/16
 * Time: 23:00
 */
class TestCommand implements CommandInterface {

	private $message;

	/**
	 * TestCommand constructor.
	 *
	 * @param $message
	 */
	public function __construct( $message ) {
		$this->message = $message;
	}

	/**
	 * @return bool
	 */
	function execute() {
		echo $this->message;

		return true;
	}
}
