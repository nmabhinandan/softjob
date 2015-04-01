<?php namespace Softjob\Commands;

//use Illuminate\Contracts\Bus\SelfHandling;

class getTasksOfProject extends Command {

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
		$this->projectId = $projectId;
	}

}
