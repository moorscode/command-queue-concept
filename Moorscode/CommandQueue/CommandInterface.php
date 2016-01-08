<?php

namespace Moorscode\CommandQueue;

/**
 * Class AbstractCommand
 */
interface CommandInterface {
	/**
	 * @return bool
	 */
	public function execute();
}
