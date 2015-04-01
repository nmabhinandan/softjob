<?php namespace Softjob\Commands;

class GetUserContextOptionsCommand extends Command {

	/**
	 * @var
	 */
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
