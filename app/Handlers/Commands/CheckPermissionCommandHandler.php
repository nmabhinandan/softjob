<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\CheckPermissionCommand;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Permission;
use Softjob\User;

class CheckPermissionCommandHandler {

	/**
	 * @var Permission
	 */
	private $permission;
	/**
	 * @var User
	 */
	private $user;

	/**
	 * Create the command handler.
	 *
	 * @param Permission $permission
	 * @param User $user
	 */
	public function __construct(Permission $permission, User $user)
	{
		$this->permission = $permission;
		$this->user = $user;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CheckPermissionCommand  $command
	 * @return void
	 */
	public function handle(CheckPermissionCommand $command)
	{
		$userPermissions = $this->user->find($command->userId)->permissions()->get()->toArray();
		foreach ($userPermissions as $up) {
			if($up['permission'] === $command->permission) {
				return true;
			}
		}
		return false;

	}

}
