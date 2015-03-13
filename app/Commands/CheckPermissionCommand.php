<?php namespace Softjob\Commands;

use Softjob\Commands\Command;

class CheckPermissionCommand extends Command {

	/**
	 * @var
	 */
	public $permission;
	/**
	 * @var
	 */
	public $userId;

	/**
	 * Create a new command instance.
	 *
	 * @param $permission
	 * @param $userId
	 */
	public function __construct($permission, $userId)
	{
		$this->permission = $permission;
		$this->userId = $userId;
	}

}
