<?php

class CommandQueueItem {
	private $command;
	private $priority;
	private $prerequisite;

	public function __construct( CommandInterface $command, $priority ) {
		$this->command = $command;
		$this->priority = $priority;
	}

	/**
	 * @param string $id
	 */
	public function setPrerequiste( $id ) {
		$this->prerequisite = $id;
	}

	/**
	 * @return CommandInterface
	 */
	public function getCommand() {
		return $this->command;
	}

	/**
	 * @return mixed
	 */
	public function getPriority() {
		return $this->priority;
	}

	/**
	 * @return string
	 */
		public function getPrerequisite() {
		return $this->prerequisite;
	}
}