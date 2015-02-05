<?php  namespace Softjob\Modules\Users;


use Softjob\Modules\ExposesPermissionsInterface;

class UserPermissions implements ExposesPermissionsInterface{

	/**
	 * Set permissions for the module
	 * @return mixed
	 */
	public function setPermissions()
	{
		// TODO: Implement setPermissions() method.
	}

	/**
	 * Check whether the user has the permission or not
	 *
	 * @param $permission
	 *
	 * @return bool
	 */
	public function checkUserPermission( $permission )
	{
		// TODO: Implement checkUserPermission() method.
	}

	/**
	 * Check whether the role has the permission or not
	 *
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function checkRolePermission( $permission )
	{
		// TODO: Implement checkRolePermission() method.
	}
}