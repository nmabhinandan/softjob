<?php namespace Softjob\Contracts\Repositories;

interface PermissionRepoInterface {

	/**
	 * Create or update the given permission
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function createOrUpdatePermission($permission);

	/**
	 * Get all of the permissions
	 *
	 * @return mixed
	 */
	public function getAllPermissions();

	/**
	 * Set the permission to a user/role
	 * @param $data
	 *
	 * @return mixed
	 */
	public function setPermission($data);

	/**
	 * Check whether the use has the permission or not
	 *
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function checkPermission($permission);
}