<?php namespace Softjob\Contracts\Modules;

interface ExposesPermissionsInterface {

	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions( );

	/**
	 * Check whether the user has the permission or not
	 *
	 * @param $permission
	 * @return bool
	 */
	public function checkUserPermission($permission);

	/**
	 * Check whether the role has the permission or not
	 *
	 * @param $permission
	 * @return bool
	 */
	public function checkRolePermission($permission);
}