<?php namespace Softjob\Commands;

class CalculateProjectsStatus extends Command {

	public $userId;

	/**
	 * Create a new command instance.
	 *
	 * @param $userId
	 */
	public function __construct( $userId )
	{
		$this->userId = $userId;
	}

}
