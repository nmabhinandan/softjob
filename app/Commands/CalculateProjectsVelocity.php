<?php namespace Softjob\Commands;

use Softjob\Commands\Command;

class CalculateProjectsVelocity extends Command {

	/**
	 * @var
	 */
	public $projectId;

	/**
	 * Create a new command instance.
	 *
	 * @param $projectId
	 */
	public function __construct($projectId)
	{
		//
		$this->projectId = $projectId;
	}

}
