<?php namespace Softjob\Commands;

use Illuminate\Contracts\Bus\SelfHandling;

class getProjectsOfUser extends Command {

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
