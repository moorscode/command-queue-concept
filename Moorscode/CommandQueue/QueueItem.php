<?php

namespace Moorscode\CommandQueue;

/**
 * Class CommandQueueItem
 */
class QueueItem implements CommandInterface {
	/**
	 * @var CommandInterface
	 */
	private $command;

	/**
	 * @var int
	 */
	private $priority;

	/**
	 * @var string
	 */
	private $prerequisite;

	/**
	 * @var string
	 */
	private $identifier;

	/**
	 * CommandQueueItem constructor.
	 *
	 * @param CommandInterface $command
	 * @param int $priority
	 */
	public function __construct( CommandInterface $command, $priority ) {
		$this->command = $command;
		$this->priority = $priority;
	}

	public function setIdentifier( $id ) {
		$this->identifier = $id;
	}

	public function getIdentifier() {
		return $this->identifier;
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
	 * @return int
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

	/**
	 * @return bool
	 */
	public function execute() {
		return $this->command->execute();
	}
}