<?php

/**
 * Created by PhpStorm.
 * User: jip
 * Date: 07/01/16
 * Time: 23:00
 */
class TestCommand implements CommandInterface {

	/**
	 * @return bool
	 */
	function execute() {
		echo 'Test Command executed.';

		return true;
	}
}
