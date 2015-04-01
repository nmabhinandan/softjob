<?php namespace Softjob\Commands;

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
	public function __construct( $projectId )
	{
		//
		$this->projectId = $projectId;
	}

}
