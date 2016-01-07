<?php

/**
 * Created by PhpStorm.
 * User: jip
 * Date: 07/01/16
 * Time: 23:25
 */
class AnotherTestCommand implements CommandInterface {

	/**
	 * @return bool
	 */
	public function execute() {
		echo 'Another Test Command executed.';

		return true;
	}
}
