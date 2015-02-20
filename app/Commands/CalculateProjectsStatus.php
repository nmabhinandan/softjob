<?php namespace Softjob\Commands;

use Softjob\Commands\Command;

class CalculateProjectsStatus extends Command {

	public $userId;

	/**
	 * Create a new command instance.
	 *
	 * @param $userId
	 */
	public function __construct($userId)
	{
		$this->userId = $userId;
	}

}
