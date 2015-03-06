<?php  namespace Softjob\Repositories;



use OpenCloud\Identity\Constants\User;
use Softjob\Contracts\Repositories\PermissionRepoInterface;
use Softjob\Permission;
use Softjob\Services\AuthService;

class EloquentPermissionRepo implements PermissionRepoInterface {


	/**
	 * @var Permission
	 */
	protected $model;

	function __construct(Permission $model)
	{
		$this->model = $model;
	}

	public function createOrUpdatePermission($permission)
	{
		$this->model->updateOrCreate([
			'permission' => $permission
		]);
	}

	public function getPermissionsOfUser()
	{
		return User::find(AuthService::$loggedInUser)->permissions()->get();
	}

	/**
	 * Get all of the permissions
	 *
	 * @return mixed
	 */
	public function getAllPermissions()
	{
		$permissions = $this->model->all()->toArray();
		$usersPermissions = $this->getPermissionsOfUser();
		$result = [];

		foreach ($permissions as $permission) {
			foreach ($usersPermissions as $up) {
				if($permission == $up) {sssss
					//todo
					array_push($result, $permission);
				}
			}

		}

		return $permissions;
	}

	/**
	 * Set the permission to a user/role
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function setPermission( $data )
	{

	}

	/**
	 * Check whether the use has the permission or not
	 *
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function checkPermission( $permission )
	{
		// TODO: Implement checkPermission() method.
	}
}