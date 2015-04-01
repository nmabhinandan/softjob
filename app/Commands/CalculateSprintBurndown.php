<?php namespace Softjob\Commands;

class CalculateSprintBurndown extends Command {

	/**
	 * @var
	 */
	public $sprintId;

	/**
	 * Create a new command instance.
	 *
	 * @param $sprintId
	 */
	public function __construct( $sprintId )
	{
		$this->sprintId = $sprintId;
	}

}
