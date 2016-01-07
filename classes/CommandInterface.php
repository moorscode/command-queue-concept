<?php

/**
 * Class AbstractCommand
 */
interface CommandInterface {
	/**
	 * @return bool
	 */
	public function execute();
}
