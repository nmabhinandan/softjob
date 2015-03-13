<?php  namespace Softjob\Repositories;



use Softjob\Contracts\Repositories\PermissionRepoInterface;
use Softjob\Permission;
use Softjob\Role;
use Softjob\Services\AuthService;
use Softjob\User;

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

	public function getPermissionsOfUser($userId)
	{
		return User::find($userId)->permissions()->get()->toArray();
	}


	/**
	 * Get all of the permissions
	 *
	 * @param $userId
	 *
	 * @return mixed
	 */
	public function getUserPermissions($userId)
	{
		/**
		 * This should be extracted to SQL query
		 */

		$usersPermissions = $this->getPermissionsOfUser($userId);
		$role = User::find($userId)->role()->get()->toArray();
		$role = array_pop($role);
		$rolePermissions = Role::find($role['id'])->permissions()->get()->toArray();
		$result = [];

		$permissions = $this->model->all()->toArray();

		foreach ($permissions as $perm) {
			foreach ($usersPermissions as $up) {
				if($perm['permission'] === $up['permission']) {
					$perm['granted'] = true;
				}
			}

			foreach ($rolePermissions as $rp) {
				if($perm['permission'] === $rp['permission']) {
					$perm['granted'] = true;
				}
			}

			$result[] = $perm;
		};

		return $result;
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
		if(array_has($data, 'userId')) {
			$model = User::find($data['userId']);
		} else if(array_has($data, 'roleId')) {
			$model = Role::find($data['roleId']);
		}

		$permission = $this->model->where('permission', '=', $data['permission'])->first()->toArray();
		if($data['granted']) {
			$model->permissions()->attach($permission['id']);
		} else {
			$model->permissions()->detach($permission['id']);
		}

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

	/**
	 * Get permissions of the role
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 */
	public function getRolePermission( $roleId )
	{
		/**
		 * This should be extracted to SQL query
		 */

		$rolePermissions = Role::find($roleId)->permissions()->get();
		$result = [];

		$permissions = $this->model->all()->toArray();

		foreach ($permissions as $perm) {
			foreach ($rolePermissions as $rp) {
				if($perm['permission'] === $rp['permission']) {
					$perm['granted'] = true;
				}
			}
			$result[] = $perm;
		};

		return $result;

	}
}